<?php

namespace Easymailing\App\Core\Provider\Elementor;

use Easymailing\App\Api\Exception\AuthenticationException;
use Easymailing\App\Api\Exception\RequestException;
use Easymailing\App\Core\Application;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use ElementorPro\Core\Utils;
use ElementorPro\Modules\Forms\Classes\Action_Base;
use ElementorPro\Modules\Forms\Classes\Form_Record;
use ElementorPro\Modules\Forms\Controls\Fields_Map;

class EasymailingFormAction extends Action_Base
{

	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function get_name() {
		return 'easymailing';
	}

	public function get_label() {
		return esc_html__( 'EasyMailing', 'easymailing' );
	}

	public function register_settings_section( $widget ) {

		$widget->start_controls_section(
			'section_easymailing',
			[
				'label' => esc_html__( 'EasyMailing', 'easymailing' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		if($this->isConfigOk() === false){

			$settings_page_url = admin_url('admin.php?page=easymailing_configuration');

			// translators: %1$s: Start tag for the link to the plugin settings page, %2$s: End tag for the link
			$warning_message = sprintf(
				esc_html__('La API Key de EasyMailing no está configurada. Por favor, configúrala en la %1$sconfiguración del plugin%2$s de EasyMailing.', 'easymailing'),
				'<a href="' . esc_url($settings_page_url) . '">',
				'</a>'
			);


			$widget->add_control(
				'easymailing_api_key_warning',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<div>' . $warning_message . '</div>',
					'content_classes' => 'your-class',
				]
			);

			$widget->end_controls_section();
			return;
		}


		$client = $this->application->getContainer()->get('api_client');
		$audiences = $client->getAudiences();

		$audienceOptions = [];

		foreach($audiences as $audience){
			$audienceOptions[$audience->id] = $audience->title;
		}

		// Control para seleccionar la audiencia
		$widget->add_control(
			'easymailing_audience',
			[
				'label' => esc_html__( 'Audiencia', 'easymailing' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $audienceOptions,
				'description' => esc_html__( 'Selecciona la audiencia de EasyMailing.', 'easymailing' ),
			]
		);

		// Control para seleccionar los grupos de la audiencia
		$widget->add_control(
			'easymailing_groups',
			[
				'label' => esc_html__( 'Grupos', 'easymailing' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [],
				'description' => esc_html__( 'Selecciona uno o varios grupos para vincular los suscriptores que se suscriban en el formularios.', 'easymailing' ),
				'condition' => [
					'easymailing_audience!' => '', // Esta línea asegura que 'easymailing_groups' solo se muestre si 'easymailing_audience' no está vacío.
				],
			]
		);

		$repeater = new Repeater();
		$repeater->add_control('remote_id', ['type' => Controls_Manager::HIDDEN]);
		$repeater->add_control('local_id', ['type' => Controls_Manager::SELECT]);

		$widget->add_control(
			'easymailing_fields_map',
			[
				'label' => esc_html__( 'Mapeo de campos', 'easymailing' ),
				'type'      => Fields_Map::CONTROL_TYPE,
				'separator' => 'before',
				'fields'    => $repeater->get_controls()
			]
		);


		$widget->end_controls_section();
	}

	public function run( $record, $ajax_handler ) {
		$client = $this->application->getContainer()->get('api_client');

		$settings = $record->get( 'form_settings' );
		$audience = $settings['easymailing_audience'];
		$groups = $settings['easymailing_groups'];
		$fieldsMapping = $settings['easymailing_fields_map'];
		$fields = $record->get( 'fields' );

		$email = $this->getMappedField( $record, 'email' );

		$body = [
			'email' => $email,
			'groups' => $groups,
			'client_ip' => Utils::get_client_ip(),
			'custom_fields' => [],
		];

		$treatmentPurposes = [];

		foreach ($fieldsMapping as $fieldMapping) {
			$value = $fields[$fieldMapping['local_id']]['value'];
			if (empty($value) and $fieldMapping['remote_type'] !== 'acceptance') {
				continue;
			}

			if($fieldMapping['remote_type'] === 'date'){
				$value = \DateTime::createFromFormat('Y-m-d', $value)->format('Y-m-d\TH:i:s\Z');
			}

			if($fieldMapping['remote_type'] === 'acceptance'){
				$value = ! empty($value);
			}

//			var_dump($fields[ $fieldMapping['local_id']]['value']);
//			var_dump($fieldMapping);

			// si remote_id contiene list_fields, entonces es un campo personalizado
			if(strpos($fieldMapping['remote_id'], 'list_fields') !== false){
				$body['custom_fields'][] = [
					'list_field' => $fieldMapping['remote_id'],
					'value' => $value
				];
			}

			//si remote_id contiene treatment_purposes, entonces es un treatment purpose
			if(strpos($fieldMapping['remote_id'], 'treatment_purposes') !== false){
				$treatmentPurposes[] = $fieldMapping['remote_id'];
			}
		}

		if($treatmentPurposes){
			$body['member_consent'] = [
				'ip' => Utils::get_client_ip(),
				'consent_at' => (new \DateTime("now", new \DateTimeZone("UTC")))->format('Y-m-d\TH:i:s\Z'),
				'treatment_purposes' => $treatmentPurposes
			];
		}

		try {
			$client->createMember($audience, $body);
			$ajax_handler->set_success(true);
			return;

		}catch(RequestException $exception) {
			$ajax_handler->add_error_message($exception->getMessage());
		}

	}

	private function getMappedField( Form_Record $record, $field_id ) {
		$fields = $record->get( 'fields' );
		foreach ( $record->get_form_settings( 'easymailing_fields_map' ) as $map_item ) {
			if ( empty( $fields[ $map_item['local_id'] ]['value'] ) ) {
				continue;
			}

			if ( $field_id === $map_item['remote_id'] ) {
				return $fields[ $map_item['local_id'] ]['value'];
			}
		}

		return '';
	}


	public function on_export( $element ) {
		unset(
			$element['easymailing_api_key_warning'],
			$element['easymailing_audience'],
			$element['easymailing_groups'],
			$element['easymailing_fields_map'],
		);

		return $element;
	}


	private function isConfigOk()
	{
		$repository = $this->application->getContainer()->get('config_repository');
		$config = $repository->getConfig();
		$client = $this->application->getContainer()->get('api_client');

		if(!$config){
			return false;
		}

		if(!$config->getApiKey()){
			return false;
		}

		try {
			$client->checkAuth($config->getApiKey());
			return true;
		}catch(AuthenticationException $e) {
			return false;
		}
	}
}
