<?php
/**
 * Contains definition for \Crown\ListTableColumn class.
 */

namespace Crown;


/**
 * List table column configuration class.
 *
 * Serves as a handler for object list table columns in WordPress admin.
 *
 * @since 2.0.0
 */
class ListTableColumn {

	/**
	 * Column key.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * Column title.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Column position in list table column order.
	 *
	 * @since 2.0.0
	 *
	 * @var int
	 */
	protected $position;

	/**
	 * Pointer to callback function that generate's the column's content.
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $outputCb;

	/**
	 * Additional arguments to pass to column's output callback.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $outputCbArgs;

	/**
	 * Pointer to callback function to add arguments to object query.
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $sortCb;

	/**
	 * Default column configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultListTableColumnArgs = array(
		'key' => '',
		'title' => '',
		'position' => null,
		'outputCb' => null,
		'outputCbArgs' => array(),
		'sortCb' => null
	);


	/**
	 * List table column object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Column configuration options. Possible arguments:
	 *    * __key__ - (string) Column key.
	 *    * __title__ - (string) Column title.
	 *    * __position__ - (int) Column position in list table column order.
	 *    * __outputCb__ - (callback) Pointer to callback function that generate's the column's content.
	 *    * __outputCbArgs__ - (array) Additional arguments to pass to column's output callback.
	 *    * __sortCb__ - (callback) Pointer to callback function to add arguments to object query.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$listTableColumnArgs = array_merge($this::$defaultListTableColumnArgs, array_intersect_key($args, $this::$defaultListTableColumnArgs));

		// parse args into object variables
		$this->setKey($listTableColumnArgs['key']);
		$this->setTitle($listTableColumnArgs['title']);
		$this->setPosition($listTableColumnArgs['position']);
		$this->setOutputCb($listTableColumnArgs['outputCb']);
		$this->setOutputCbArgs($listTableColumnArgs['outputCbArgs']);
		$this->setSortCb($listTableColumnArgs['sortCb']);

	}


	/**
	 * Get column key.
	 *
	 * @since 2.0.0
	 *
	 * @return string Column key.
	 */
	public function getKey() {
		return $this->key;
	}


	/**
	 * Get column title.
	 *
	 * @since 2.0.0
	 *
	 * @return string Column title.
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * Get column position in list table column order.
	 *
	 * @since 2.0.0
	 *
	 * @return int Column position.
	 */
	public function getPosition() {
		return $this->position;
	}


	/**
	 * Get pointer to column output callback.
	 *
	 * @since 2.0.0
	 *
	 * @return callback Column output callback pointer.
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
	 * Get pointer to column sorting callback.
	 *
	 * @since 2.0.0
	 *
	 * @return callback Column sorting callback pointer.
	 */
	public function getSortCb() {
		return $this->sortCb;
	}


	/**
	 * Set column key.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key Column key.
	 */
	public function setKey($key) {
		$this->key = $key;
	}


	/**
	 * Set column title.
	 *
	 * @since 2.0.0
	 *
	 * @param string $title Column title.
	 */
	public function setTitle($title) {
		$this->title = $title;
	}


	/**
	 * Set column position.
	 *
	 * @since 2.0.0
	 *
	 * @param int $position Column position.
	 */
	public function setPosition($position) {
		if($position !== null) $this->position = intval($position);
	}


	/**
	 * Set column output callback function.
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
	 * Set column sorting callback function.
	 *
	 * @since 2.0.0
	 *
	 * @param callback $sortCb Sorting callback pointer.
	 */
	public function setSortCb($sortCb) {
		$this->sortCb = $sortCb;
	}


	/**
	 * Asserts if column should be sortable.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Whether column should be sortable.
	 */
	public function isSortable() {
		return is_callable($this->sortCb);
	}


	/**
	 * Add column to list of default columns.
	 *
	 * Method should be called during object object column management filter hook.
	 * Column is inserted into default columns array based on column's position.
	 *
	 * @since 2.0.0
	 *
	 * @param array $defaults Default list table columns.
	 *
	 * @return array List table columns.
	 */
	public function addColumn($defaults) {

		$column = array($this->key => $this->title);

		// spice in at specified position
		if(is_int($this->position) && $this->position >= 0 && $this->position < count($defaults)) {
			return array_slice($defaults, 0, $this->position, true) + $column + array_slice($defaults, $this->position, null, true);
		}

		// append to end of column list
		return $defaults + $column;

	}


	/**
	 * Output the list table column content for a specific object.
	 *
	 * @since 2.0.0
	 *
	 * @param int $objectId Object ID.
	 */
	public function output($objectId) {
		echo $this->getOutput($objectId);
	}


	/**
	 * Get the list table column content for a specific object.
	 *
	 * @since 2.0.0
	 *
	 * @param int $objectId Object ID.
	 *
	 * @return string Column output content.
	 */
	public function getOutput($objectId) {

		// output column data
		if(is_callable($this->outputCb)) {
			// custom column data output
			ob_start();
			call_user_func($this->outputCb, $objectId, $this->outputCbArgs);
			return ob_get_clean();
		}

		return '';

	}


	/**
	 * Add query variables to sort list objects.
	 *
	 * @since 2.0.0
	 *
	 * @param array $queryVars Default object query variables.
	 *
	 * @return array Mofified object query variables.
	 */
	public function addSortQueryVars($queryVars) {
		if(is_callable($this->sortCb)) {
			$queryVars = call_user_func($this->sortCb, $queryVars);
		}
		return $queryVars;
	}


}