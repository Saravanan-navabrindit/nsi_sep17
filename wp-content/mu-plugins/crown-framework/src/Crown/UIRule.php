<?php
/**
 * Contains definition for \Crown\UIRule class.
 */

namespace Crown;


/**
 * UI rule configuration class.
 *
 * Serves as a handler for conditional admin UI rule.
 *
 * @since 2.1.0
 */
class UIRule {

	/**
	 * UI rule property to test.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected $property;

	/**
	 * Assertion of rule.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected $compare;

	/**
	 * Value to compare.
	 *
	 * @since 2.1.0
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Rule options.
	 *
	 * @since 2.1.0
	 *
	 * @var mixed
	 */
	protected $options;

	/**
	 * Custom rule evaluation callback.
	 *
	 * @since 2.1.0
	 *
	 * @var callback
	 */
	protected $evaluateCb;

	/**
	 * Default shortcode configuration options.
	 *
	 * @since 2.1.0
	 *
	 * @var array
	 */
	protected static $defaultUIRuleArgs = array(
		'property' => '',
		'compare' => '=',
		'value' => array(),
		'options' => array(),
		'evaluateCb' => null
	);


	/**
	 * UI rule object constructor.
	 *
	 * Parses configuration options into object properties and registers relevant action/filter hooks.
	 *
	 * @since 2.1.0
	 *
	 * @param array $args Optional. Shortcode configuration options. Possible arguments:
	 *    * __property__ - (string) UI rule property to test.
	 *    * __compare__ - (string) Assertion of rule.
	 *    * __value__ - (mixed) Value to compare.
	 *    * __options__ - (mixed) Rule options.
	 *    * __evaluateCb__ - (callback) Custom rule evaluation callback.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$uIRuleArgs = array_merge($this::$defaultUIRuleArgs, array_intersect_key($args, $this::$defaultUIRuleArgs));

		// parse options into object properties
		$this->setProperty($uIRuleArgs['property']);
		$this->setCompare($uIRuleArgs['compare']);
		$this->setValue($uIRuleArgs['value']);
		$this->setOptions($uIRuleArgs['options']);
		$this->setEvaluateCb($uIRuleArgs['evaluateCb']);

		// register hooks

	}


	/**
	 * Get rule property to test.
	 *
	 * @since 2.1.0
	 *
	 * @return string Property to test.
	 */
	public function getProperty() {
		return $this->property;
	}


	/**
	 * Get assertion of rule.
	 *
	 * @since 2.1.0
	 *
	 * @return string Assertion of rule.
	 */
	public function getCompare() {
		return $this->compare;
	}


	/**
	 * Get value to compare.
	 *
	 * @since 2.1.0
	 *
	 * @return mixed Value to compare.
	 */
	public function getValue() {
		return $this->value;
	}


	/**
	 * Get rule options.
	 *
	 * @since 2.1.0
	 *
	 * @return mixed Rule options.
	 */
	public function getOptions() {
		return $this->options;
	}


	/**
	 * Get custom rule evaluation callback.
	 *
	 * @since 2.1.0
	 *
	 * @return mixed Custom rule evaluation callback.
	 */
	public function getEvaluateCb() {
		return $this->evaluateCb;
	}


	/**
	 * Set rule property to test.
	 *
	 * @since 2.1.0
	 *
	 * @param string $property Property to test.
	 */
	public function setProperty($property) {
		$this->property = $property;
	}


	/**
	 * Set assertion of rule.
	 *
	 * @since 2.1.0
	 *
	 * @param string $compare Assertion of rule.
	 */
	public function setCompare($compare) {
		$this->compare = $compare;
	}


	/**
	 * Set value to compare.
	 *
	 * @since 2.1.0
	 *
	 * @param mixed $value Value to compare.
	 */
	public function setValue($value) {
		$this->value = is_array($value) ? $value : array($value);
	}


	/**
	 * Set rule options.
	 *
	 * @since 2.1.0
	 *
	 * @param mixed $options Rule options.
	 */
	public function setOptions($options) {
		if(is_array($options)) {
			$this->options = array_merge(array(
				'taxonomy' => '',
				'inputName' => ''
			), $options);
		}
	}


	/**
	 * Set custom rule evaluation callback.
	 *
	 * @since 2.1.0
	 *
	 * @param callback $evaluateCb Custom rule evaluation callback.
	 */
	public function setEvaluateCb($evaluateCb) {
		$this->evaluateCb = $evaluateCb;
	}


	/**
	 * Evaluate the rule.
	 *
	 * This method is added to the 'init' action hook.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluate($objectId = null) {

		wp_enqueue_script('crown-ui-rule');

		if(is_callable($this->evaluateCb)) {
			return call_user_func($this->evaluateCb, $objectId);
		}

		if(empty($this->property)) return false;
		if(empty($this->compare)) return false;

		$evalMethod = 'evaluate'.ucfirst($this->property);
		if(!method_exists($this, $evalMethod)) return false;

		return call_user_func(array(&$this, $evalMethod), $objectId);

	}


	/**
	 * Compare the object's ID.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluateObjectId($objectId) {
		if($objectId === null) return false;
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($objectId, $this->value);
				break;
			
			default:
				return in_array($objectId, $this->value);
				break;

		}
	}


	/**
	 * Compare the post's ID.
	 *
	 * @since 2.1.0
	 *
	 * @uses \Crown\UIRule::evaluateObjectId() to compare object's ID.
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePostId($objectId) {
		return $this->evaluateObjectId($objectId);
	}


	/**
	 * Compare the term's ID.
	 *
	 * @since 2.1.0
	 *
	 * @uses \Crown\UIRule::evaluateObjectId() to compare object's ID.
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluateTermId($objectId) {
		return $this->evaluateObjectId($objectId);
	}


	/**
	 * Compare the post's post type.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePostType($objectId) {
		if($objectId === null) return false;
		$postType = get_post_type($objectId);
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($postType, $this->value);
				break;
			
			default:
				return in_array($postType, $this->value);
				break;

		}
	}


	/**
	 * Compare the post's registered taxonomies.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePostTaxonomy($objectId) {
		if($objectId === null) return false;
		$postType = get_post_type($objectId);
		$validPostTypes = array();
		foreach($this->value as $taxonomyName) {
			$taxonomy = get_taxonomy($taxonomyName);
			if(empty($taxonomy)) continue;
			$validPostTypes = array_merge($validPostTypes, $taxonomy->object_type);
		}
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($postType, $validPostTypes);
				break;
			
			default:
				return in_array($postType, $validPostTypes);
				break;

		}
	}


	/**
	 * Compare the page type.
	 *
	 * Whether the page is set to the the home, blog, a top level, parent, or chid page.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePageType($objectId) {
		if($objectId === null) return false;

		$active = false;
		$post = get_post($objectId);
		if(empty($post) || $post->post_type != 'page') return false;
		
		foreach($this->value as $pageType) {
			if($pageType == 'home') {
				$postId = get_option('page_on_front');
				if($postId == $post->ID) $active = true;
			} else if($pageType == 'blog') {
				$postId = get_option('page_for_posts');
				if($postId == $post->ID) $active = true;
			} else if($pageType == 'topLevel') {
				if($post->post_parent == 0) $active = true;
			} else if($pageType == 'parent') {
				$children = get_posts(array('post_type' => 'page', 'post_parent' => $post->ID));
				if(!empty($children)) $active = true;
			} else if($pageType == 'child') {
				if($post->post_parent != 0) $active = true;
			}
		}

		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !$active;
				break;
			
			default:
				return $active;
				break;

		}
	}


	/**
	 * Compare the user's permissions.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluateUserPermission($objectId) {

		$active = false;
		
		foreach($this->value as $permission) {
			if(current_user_can($permission)) $active = true;
		}

		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !$active;
				break;
			
			default:
				return $active;
				break;

		}
	}


	/**
	 * Compare the user's ID.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluateUserId($objectId) {
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array(get_current_user_id(), $this->value);
				break;
			
			default:
				return in_array(get_current_user_id(), $this->value);
				break;

		}
	}


	/**
	 * Compare the post's parent.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePostParent($objectId) {
		if($objectId === null) return false;

		$active = false;
		$post = get_post($objectId);
		if(empty($post)) return false;
		
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($post->post_parent, $this->value);
				break;
			
			default:
				return in_array($post->post_parent, $this->value);
				break;

		}
	}


	/**
	 * Compare the post's format.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePostFormat($objectId) {
		if($objectId === null) return false;
		$postFormat = get_post_format($objectId);
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($postFormat, $this->value);
				break;
			
			default:
				return in_array($postFormat, $this->value);
				break;

		}
	}


	/**
	 * Compare the post's taxonomy terms.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluateTaxonomyTerm($objectId) {
		if($objectId === null) return false;
		$terms = wp_get_object_terms($objectId, $this->options['taxonomy'], array('fields' => 'ids'));
		if(is_wp_error($terms)) return false;
		$matches = array_intersect($this->value, $terms);
		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return empty($matches);
				break;
			
			default:
				return !empty($matches);
				break;

		}
	}


	/**
	 * Compare the page's template.
	 *
	 * @since 2.1.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function evaluatePageTemplate($objectId) {
		if($objectId === null) return false;

		$active = false;
		$pageTemplate = get_page_template_slug($objectId);
		$pageTemplate = $pageTemplate === '' ? 'default' : $pageTemplate;
		if(empty($pageTemplate)) return false;

		switch(strtolower($this->compare)) {

			case '!=':
			case 'not in':
				return !in_array($pageTemplate, $this->value);
				break;
			
			default:
				return in_array($pageTemplate, $this->value);
				break;

		}
	}


}