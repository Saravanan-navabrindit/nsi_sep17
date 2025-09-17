<?php
/**
 * Contains definition for \Crown\AdminPage class.
 */

namespace Crown;


/**
 * Admin page configuration class.
 *
 * Serves as a handler for admin pages in WordPress.
 *
 * @since 2.0.0
 */
class AdminPage {

	/**
	 * Page key.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * Parent page slug or section.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $parent;

	/**
	 * Page title.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Menu title.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $menuTitle;

	/**
	 * Page user capability restriction.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $capability;

	/**
	 * Menu icon path or dashicons class.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $icon;

	/**
	 * Menu position.
	 *
	 * @since 2.0.0
	 *
	 * @var int
	 */
	protected $position;

	/**
	 * Page output callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $outputCb;

	/**
	 * Additional arguments to pass to page output callback.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $outputCbArgs;

	/**
	 * Page settings save callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $saveMetaCb;

	/**
	 * Additional arguments to pass to page settings save callback.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $saveMetaCbArgs;

	/**
	 * Page option fields.
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $fields;

	/**
	 * Default page configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultAdminPageArgs = array(
		'key' => '',
		'parent' => '',
		'title' => '',
		'menuTitle' => '',
		'capability' => 'manage_options',
		'icon' => '',
		'position' => null,
		'outputCb' => null,
		'outputCbArgs' => array(),
		'saveMetaCb' => null,
		'saveMetaCbArgs' => array(),
		'fields' => array()
	);


	/**
	 * Admin page object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Page configuration options. Possible arguments:
	 *    * __key__ - (string) Page key.
	 *    * __parent__ - (string) Parent page slug or section.
	 *    * __title__ - (string) Page title.
	 *    * __menuTitle__ - (string) Menu title.
	 *    * __capability__ - (string) Page user capability restriction.
	 *    * __icon__ - (string) Menu icon path or dashicons class.
	 *    * __position__ - (int) Menu position.
	 *    * __outputCb__ - (callback) Page output callback pointer.
	 *    * __outputCbArgs__ - (array) Additional arguments to pass to page output callback.
	 *    * __saveMetaCb__ - (callback) Page settings save callback pointer.
	 *    * __saveMetaCbArgs__ - (array) Additional arguments to pass to page settings save callback.
	 *    * __fields__ - (\Crown\Form\Field[]) Page option fields.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$adminPageArgs = array_merge($this::$defaultAdminPageArgs, array_intersect_key($args, $this::$defaultAdminPageArgs));

		// parse args into object variables
		$this->setKey($adminPageArgs['key']);
		$this->setParent($adminPageArgs['parent']);
		$this->setTitle($adminPageArgs['title']);
		$this->setMenuTitle($adminPageArgs['menuTitle']);
		$this->setCapability($adminPageArgs['capability']);
		$this->setIcon($adminPageArgs['icon']);
		$this->setPosition($adminPageArgs['position']);
		$this->setOutputCb($adminPageArgs['outputCb']);
		$this->setOutputCbArgs($adminPageArgs['outputCbArgs']);
		$this->setSaveMetaCb($adminPageArgs['saveMetaCb']);
		$this->setSaveMetaCbArgs($adminPageArgs['saveMetaCbArgs']);
		$this->setFields($adminPageArgs['fields']);

		// register hooks
		add_action('admin_menu', array(&$this, 'addMenuPage'));

	}


	/**
	 * Get page key.
	 *
	 * @since 2.0.0
	 *
	 * @return string Page key.
	 */
	public function getKey() {
		return $this->key;
	}


	/**
	 * Get parent page slug or section.
	 *
	 * @since 2.0.0
	 *
	 * @return string Parent page slug or section.
	 */
	public function getParent() {
		return $this->parent;
	}


	/**
	 * Get page title.
	 *
	 * @since 2.0.0
	 *
	 * @return string Page title.
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * Get menu title.
	 *
	 * @since 2.0.0
	 *
	 * @return string Menu title.
	 */
	public function getMenuTitle() {
		return $this->menuTitle;
	}


	/**
	 * Get user capability restriction.
	 *
	 * @since 2.0.0
	 *
	 * @return string User capability restriction.
	 */
	public function getCapability() {
		return $this->capability;
	}


	/**
	 * Get menu icon path or dashicons class.
	 *
	 * @since 2.0.0
	 *
	 * @return string Menu icon path or dashicons class.
	 */
	public function getIcon() {
		return $this->icon;
	}


	/**
	 * Get menu position.
	 *
	 * @since 2.0.0
	 *
	 * @return int Menu position.
	 */
	public function getPosition() {
		return $this->position;
	}


	/**
	 * Get output callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @return callback Output callback pointer.
	 */
	public function getOutputCb() {
		return $this->outputCb;
	}


	/**
	 * Get output callback arguments.
	 *
	 * @since 2.0.0
	 *
	 * @return array Output callback arguments.
	 */
	public function getOutputCbArgs() {
		return $this->outputCbArgs;
	}


	/**
	 * Get page settings save callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @return callback Page settings save callback pointer.
	 */
	public function getSaveMetaCb() {
		return $this->saveMetaCb;
	}


	/**
	 * Get page settings save callback arguments.
	 *
	 * @since 2.0.0
	 *
	 * @return array Page settings save callback arguments.
	 */
	public function getSaveMetaCbArgs() {
		return $this->saveMetaCbArgs;
	}


	/**
	 * Get page option fields.
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Field[] Page option fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Set page key.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key Page key.
	 */
	public function setKey($key) {
		$this->key = $key;
	}


	/**
	 * Set parent page slug or section.
	 *
	 * @since 2.0.0
	 *
	 * @param string $parent Parent page slug or section.
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}


	/**
	 * Set page title.
	 *
	 * @since 2.0.0
	 *
	 * @param string $title Page title.
	 */
	public function setTitle($title) {
		$this->title = $title;
	}


	/**
	 * Set menu title.
	 *
	 * @since 2.0.0
	 *
	 * @param string $menuTitle Menu title.
	 */
	public function setMenuTitle($menuTitle) {
		$this->menuTitle = $menuTitle;
	}


	/**
	 * Set user capability restriction.
	 *
	 * @since 2.0.0
	 *
	 * @param string $capability User capability restriction.
	 */
	public function setCapability($capability) {
		$this->capability = $capability;
	}


	/**
	 * Set menu icon path or dashicons class.
	 *
	 * @since 2.0.0
	 *
	 * @param string $icon Menu icon path or dashicons class.
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}


	/**
	 * Set menu position.
	 *
	 * @since 2.0.0
	 *
	 * @param int $position Menu position.
	 */
	public function setPosition($position) {
		$this->position = intval($position);
	}


	/**
	 * Set output callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @param callback $outputCb Output callback pointer.
	 */
	public function setOutputCb($outputCb) {
		$this->outputCb = $outputCb;
	}


	/**
	 * Set output callback arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array $outputCbArgs Output callback arguments.
	 */
	public function setOutputCbArgs($outputCbArgs) {
		if(is_array($outputCbArgs)) $this->outputCbArgs = $outputCbArgs;
	}


	/**
	 * Set page settings save callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @param callback $saveMetaCb Page settings save callback pointer.
	 */
	public function setSaveMetaCb($saveMetaCb) {
		$this->saveMetaCb = $saveMetaCb;
	}


	/**
	 * Set page settings save callback arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array $saveMetaCbArgs Page settings save callback arguments.
	 */
	public function setSaveMetaCbArgs($saveMetaCbArgs) {
		if(is_array($saveMetaCbArgs)) $this->saveMetaCbArgs = $saveMetaCbArgs;
	}


	/**
	 * Set page option fields.
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field[] $fields Page option fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Asserts if page should be treated as a subpage.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Whether page is a subpage.
	 */
	public function isSubpage() {
		return !empty($this->parent) && !in_array($this->parent, array('object', 'utility'));
	}


	/**
	 * Add page option field.
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field $field Option field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Add page to admin menu.
	 *
	 * @since 2.0.0
	 *
	 * This method is added to the 'admin_menu' action hook.
	 */
	public function addMenuPage() {

		// set page options
		$key = $this->key;
		$pageTitle = $this->title;
		$menuTitle = !empty($this->menuTitle) ? $this->menuTitle : $pageTitle;
		$capability = $this->capability;
		$icon = $this->icon;
		$position = $this->position;
		$cb = array(&$this, 'output');

		// new admin page hook
		$hookname = '';

		// add page based on parent
		switch($this->parent) {
			case 'object':
				$hookname = add_object_page($pageTitle, $menuTitle, $capability, $key, $cb, $icon);
				break;
			case 'utility':
				$hookname = add_utility_page($pageTitle, $menuTitle, $capability, $key, $cb, $icon);
				break;
			case '':
				$hookname = add_menu_page($pageTitle, $menuTitle, $capability, $key, $cb, $icon, $position);
				break;
			case 'dashboard':
				$hookname = add_dashboard_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'posts':
				$hookname = add_posts_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'media':
				$hookname = add_media_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'pages':
				$hookname = add_pages_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'comments':
				$hookname = add_comments_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'theme':
				$hookname = add_theme_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'plugins':
				$hookname = add_plugins_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'users':
				$hookname = add_users_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'management':
				$hookname = add_management_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			case 'options':
				$hookname = add_options_page($pageTitle, $menuTitle, $capability, $key, $cb);
				break;
			default:
				$hookname = add_submenu_page($this->parent, $pageTitle, $menuTitle, $capability, $key, $cb);
				break;
		}

		// add save meta method to new page's load action hook
		add_action('load-'.$hookname, array(&$this, 'saveMeta'));

	}


	/**
	 * Output page's content.
	 *
	 * @since 2.0.0
	 */
	public function output() {
		echo $this->getOutput();
	}


	/**
	 * Get the page's content.
	 *
	 * @since 2.0.0
	 *
	 * @return string Page content HTML.
	 */
	public function getOutput() {
		ob_start();
		?>
			<div class="wrap">

				<h2><?php echo $this->title; ?></h2>

				<?php if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') { ?>
					<div class="updated settings-error">
						<p><strong>Settings saved.</strong></p>
					</div>
				<?php } ?>

				<?php if(is_callable($this->outputCb)) { ?>

					<?php call_user_func($this->outputCb, $this->outputCbArgs); ?>

				<?php } else { ?>

					<form method="post">

						<div id="crown-admin-page-fields">
							<?php
								foreach($this->fields as $field) {
									$fieldValue = $field->getValue('blog');
									$field->output(array('value' => $fieldValue));
								}
							?>
						</div>

						<p class="submit">
							<button type="submit" name="action" class="button button-primary" value="update">Save Changes</button>
						</p>

						<?php wp_nonce_field('crown_save_admin_page_'.$this->key, 'nonce_admin_page_'.$this->key); ?>

					</form>

				<?php } ?>

			</div>
		<?php
		return ob_get_clean();

	}


	/**
	 * Save the page's submitted data.
	 *
	 * This method is added to the 'load-{$hookname}' action hook.
	 *
	 * @since 2.0.0
	 */
	public function saveMeta() {

		$input = $_POST;
		$fieldsUpdated = false;

		// verify nonce field
		if(isset($_POST['nonce_admin_page_'.$this->key]) && wp_verify_nonce($_POST['nonce_admin_page_'.$this->key], 'crown_save_admin_page_'.$this->key)) {
			if(isset($_POST['action']) && $_POST['action'] == 'update') {

				// save page's fields' meta data
				foreach($this->fields as $field) {
					$field->saveValue($input, 'blog');
				}

				$fieldsUpdated = true;

			}
		}

		// additional custom page data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $input, $this->saveMetaCbArgs, $this->fields);

		// if metadata updated, redirect page to prevent resubmitting data
		if($fieldsUpdated) {
			wp_redirect(add_query_arg('settings-updated', 'true'));
			die();
		}

	}


}