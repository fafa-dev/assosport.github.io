<?php

namespace PrestoPlayer\Integrations\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use PrestoPlayer\WPackio\Enqueue;
use PrestoPlayer\Models\ReusableVideo;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * presto-player video widget.
 *
 * presto-player widget that displays a video player.
 *
 * @since 1.0.0
 */
class ReusableVideoWidget extends Widget_Base
{
	/**
	 * Get widget name.
	 *
	 * Retrieve video widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'presto_video';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve video widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return __('Presto Player', 'presto-player');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve video widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-youtube';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the video widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['basic'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['video', 'player', 'embed', 'youtube', 'vimeo'];
	}

	/**
	 * Register video widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_video',
			[
				'label' => __('Video', 'presto-player'),
			]
		);


		$options = $this->get_videos_options();
		$this->add_control(
			'video_block',
			[
				'label' => __('Choose A Video', 'presto-player'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $options,
				'default' => @[array_keys($options)[0]]
			]
		);

		$this->add_control(
			'edit_video',
			[
				'label' => __('Video Options', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'text' => __('Edit Video', 'plugin-domain'),
				'event' => 'presto:video:edit',
				// 'conditions' => [
				// 	'video_block[value]!' => null
				// ]
			]
		);

		$this->add_control(
			'create_video',
			[
				'label' => __('New Video', 'plugin-name'),
				'separator' => 'before',
				'classes' => 'testclass',
				'type' => \Elementor\Controls_Manager::BUTTON,
				'text' => __('Create Video', 'plugin-domain'),
				'event' => 'presto:video:create',
			]
		);


		$this->add_control(
			'url_override',
			[
				'label' => __('Dynamic URL Override', 'presto-player'),
				'separator' => 'before',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => __('Enter a url override', 'presto-player'),
				'default' => '',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	public function get_videos_options()
	{
		$videos = (new ReusableVideo())->fetch();
		$options = [];
		foreach ($videos as $video) {
			$options[$video->ID] = sanitize_text_field($video->post_title);
		}
		return $options;
	}

	/**
	 * Render video widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		global $load_presto_js;
		$load_presto_js = true;
		$settings = $this->get_settings_for_display();
		$video = new ReusableVideo($settings['video_block']);
		$overrides = [];
		if ($settings['url_override']) {
			$overrides['src'] = $settings['url_override'];
		}
		$render = $video->renderBlock($overrides);
		if ($render) {
			echo $render;
			return;
		}

		$video = (new ReusableVideo())->first();
		echo $video ? $video->renderBlock($overrides) : '';
	}
}
