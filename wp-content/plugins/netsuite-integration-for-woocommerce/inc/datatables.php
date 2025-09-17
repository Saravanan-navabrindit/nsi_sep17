<?php
class Datatables {
	//datatables
	public function limit( $request) {
		$limit = '';
		if (isset($request['start']) && -1 != $request['length']) {
			 $limit = 'LIMIT ' . intval($request['start']) . ', ' . intval($request['length']);
			//$limit = intval($request['start']) . ', ' . intval($request['length']);
		}
		return $limit;
	}
	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	public function order( $request, $columns) {
		$order = '';
		if (isset($request['order']) && count($request['order'])) {
			$orderBy = array();
			$dtColumns = $this->pluck($columns, 'dt');
			for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];
				if ('true' == $requestColumn['orderable']) {
					$dir = 'asc' === $request['order'][$i]['dir'] ?
							'ASC' :
							'DESC';
					$orderBy[] = '' . $column['db_ref'] . ' ' . $dir;
				}
			}
			$order = 'ORDER BY ' . implode(', ', $orderBy);
		}
		return $order;
	}
	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	public function filter( $request, $columns, &$bindings) {
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck($columns, 'dt');
		if (isset($request['search']) && '' != $request['search']['value']) {
			$str = $request['search']['value'];
			for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];
				
				if ('true' == $requestColumn['searchable']) {
									$this_db_ref  = str_replace('as ' . $column['db_ref'] , '', $column['db']);

					$globalSearch[] = '' . $this_db_ref . " LIKE '%" . $request['search']['value'] . "%'";
				   
				}
			}
		}
		// Individual column filtering
		for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
			$requestColumn = $request['columns'][$i];
			$columnIdx = array_search($requestColumn['data'], $dtColumns);
			$column = $columns[$columnIdx];
			$str = $requestColumn['search']['value'];
			if ('true' == $requestColumn['searchable'] &&
					'' != $str) {
				
				$columnSearch[] = '' . $column['db_ref'] . " LIKE '%" . $str . "%'";
			}
		}
		// Combine the filters into a single string
		$where = '';
		if (count($globalSearch)) {
			$where = '(' . implode(' OR ', $globalSearch) . ')';
		}
		if (count($columnSearch)) {
			$where = '' === $where ?
					implode(' AND ', $columnSearch) :
					$where . ' AND ' . implode(' AND ', $columnSearch);
		}
		if ('' !== $where) {
			$where = 'WHERE ' . $where;
		}
		return $where;
	}
	public function pluck( $a, $prop) {
		$out = array();
		for ($i = 0, $len = count($a); $i < $len; $i++) {
			$out[] = $a[$i][$prop];
		}
		return $out;
	}
	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	public function bind( &$a, $val, $type) {
		$key = ':binding_' . count($a);
		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);
		return $key;
	}
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	public function data_output( $columns, $data) {
//       
		$out = array();
		for ($i = 0, $ien = count($data); $i < $ien; $i++) {
			$row = array();
			for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
				$column = $columns[$j];
//               
				// Is there a formatter?
				$row[$column['dt']] = $data[$i][$columns[$j]['db_ref']];
			}
			$out[] = $row;
		}
		return $out;
	}
}

