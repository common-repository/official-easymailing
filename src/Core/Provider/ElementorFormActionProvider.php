<?php

namespace Easymailing\App\Core\Provider;

use Easymailing\App\Core\Application;
use Easymailing\App\Api\Exception\NotFoundException;

class ElementorFormActionProvider
{

	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function register()
	{
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		if (!is_plugin_active('elementor/elementor.php')) {
			return;
		}

		add_action('plugins_loaded', function() {
			$this->registerFormAction();
			$this->enqueueScripts();
			$this->registerAjaxActions();
		});
	}

	public function registerFormAction()
	{
		add_action('elementor_pro/forms/actions/register', function($actions_manager) {
			require_once __DIR__ . '/Elementor/EasymailingFormAction.php';
			$actions_manager->register(new \Easymailing\App\Core\Provider\Elementor\EasymailingFormAction($this->application));
		});
	}

	public function registerAjaxActions()
	{
		add_action('wp_ajax_easymailing_elementor_fetch_custom_fields', [$this, 'fetchCustomFields']);
		add_action('wp_ajax_easymailing_elementor_fetch_groups', [$this, 'fetchGroups']);
	}

	public function enqueueScripts()
	{
		$pluginUrl = $this->application->getConfigurations()['plugin_url'];

		add_action('elementor/editor/before_enqueue_scripts', function() use ($pluginUrl) {
			wp_enqueue_script('easymailing-elementor', $pluginUrl .'assets/build/plugin/easymailing_elementor_script.js', ['jquery', 'underscore'], EASYMAILING_OFFICIAL_VERSION, true);
			wp_localize_script('easymailing-elementor', 'easymailingElementor', [
				'fields'                  => [],
				'ajax_url'                => admin_url('admin-ajax.php'),
				'nonce'                   => wp_create_nonce('easymailing-elementor'),
			]);
		});
	}


	public function fetchGroups() {
		check_ajax_referer('easymailing-elementor', 'nonce');
		$audienceIri = sanitize_text_field($_POST['audience']);

		try {
			$audience = $this->application->getContainer()->get('api_client')->getAudienceById($audienceIri);
		}catch(NotFoundException $e){
			wp_send_json_error(['message' => 'Audience not found']);
		}


		$groupOptions = [];
		foreach ($audience->groups as $group) {
			$groupOptions[$group->id] = $group->title;
		}

		wp_send_json_success(['groups' => $groupOptions]);
	}

	public function fetchCustomFields()
	{
		check_ajax_referer('easymailing-elementor', 'nonce');
		$audienceIri =  sanitize_text_field($_POST['audience']);

		$suscription = $this->application->getContainer()->get('api_client')->getMySuscription();
		$locale = $suscription->locale;

		try {
			$audience = $this->application->getContainer()->get('api_client')->getAudienceById($audienceIri);
		}catch(NotFoundException $e){
			wp_send_json_error(['message' => 'Audience not found']);
		}

		$fields = [];
		$fields[] = [
			'remote_id'    => 'email',
			'remote_label' => 'Email',
			'remote_type'  => 'email'
		];

		foreach ($audience->listFields as $field) {
			$translationLabel = null;
			foreach ($field->translations as $translation) {
				if ($translation->locale === $locale) {
					$translationLabel = $translation->label;
					break;
				}
			}

			$fields[] = [
				'remote_id'    => $field->id,
				'remote_label' => $translationLabel,
				'remote_type'  => $this->normalizeType($field->type)
			];
		}

		foreach ($audience->listGdpr->treatmentPurposes as $treatmentPurpose) {
			$translationLabel = null;
			foreach ($treatmentPurpose->translations as $translation) {
				if ($translation->locale === $locale) {
					$translationLabel = $translation->title;
					break;
				}
			}

			$fields[] = [
				'remote_id'    => $treatmentPurpose->id,
				'remote_label' => $translationLabel,
				'remote_type'  => 'acceptance'
			];
		}

		$response = [
			'fields' => $fields
		];

		wp_send_json_success($response);
	}


	private function normalizeType( $type ) {

		static $types = [
			'list.field.type.text' => 'text',
			'list.field.type.select' => 'select',
			'list.field.type.multiselect' => 'select',
			'list.field.type.date' => 'date',
			'list.field.type.datetime' => 'date',
			'list.field.type.birthday' => 'date',
			'list.field.type.textarea' => 'textarea',
			'list.field.type.url' => 'url',
			'list.field.type.integer' => 'number',
			'list.field.type.decimal' => 'number',
			'list.field.type.money' => 'number',
			'list.field.type.language' => 'text',
			'list.field.type.boolean' => 'acceptance',
		];

		if(array_key_exists($type, $types) === false){
			return 'text';
		}

		return $types[ $type ];
	}



}
