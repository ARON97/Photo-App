<?php 

/**
* Pagination Class
*/
class Paginate
{

	public $current_page;
	public $items_per_page;
	public $items_total_count;

	// contruct function to initialize properties
	public function __construct($page = 1, $items_per_page = 4, $items_total_count = 0) {

		$this->current_page 		= (int)$page;
		$this->items_per_page 		= (int)$items_per_page;
		$this->items_total_count 	= (int)$items_total_count;
		
	}

	// next page
	public function next() {

		return $this->current_page + 1;
	}

	// previous page
	public function previous() {

		return $this->current_page - 1;
	}

	// find total page
	public function page_total() {

		// divide total page count by items per page
		return ceil($this->items_total_count / $this->items_per_page); // ceil rounds off the calculations
	}

	// detects the previous page
	public function has_previous() {

		// if our previous page is greater or equals to one then we return true otherwise false
		return $this->previous() >= 1 ? true  : false;

	}

	// detects the next page
	public function has_next() {

		// if our next page is less or equals to the page total then we return the next page otherwise when the page toal is greater or equals then we return false
		return $this->next() <= $this->page_total() ? true  : false;

	}

	// offset will skip the definite amount of page. The page will jump to the next 10
	public function offset() {

		return ($this->current_page - 1) * $this->items_per_page;
	}

}



?>