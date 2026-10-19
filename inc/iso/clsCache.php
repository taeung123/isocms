<?php 
/**
 * CodeIgniter Caching Class 
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		ExpressionEngine Dev Team
 * @link		
 */
class Cache{
	protected $_cache_path		= NULL;		// Path of cache files (if file-based cache)
	protected $_adapter			= 'file';
	protected $_extension 		= '.cache';
	protected $valid_drivers 	= array(
		'cache_apc',
		'cache_file',
		'cache_memcached',
		'cache_dummy'
	);
	/**
	* Constructor
	* @param array
	*/
	public function __construct($config = array()){
		if ( ! empty($config)){
			$this->_initialize($config);
		}
	}
	/**
	* Get 
	* Look for a value in the cache.  If it exists, return the data 
	* if not, return FALSE
	* @param 	string	
	* @return 	mixed		value that is stored/FALSE on failure
	*/
	public function get($id){
		$id = preg_replace('/\.cache/','',$id);
		return $this->_adapter->get($id.$this->_extension);
	}
	/**
	 * Cache Save
	 * @param 	string		Unique Key
	 * @param 	mixed		Data to store
	 * @param 	int			Length of time (in seconds) to cache the data
	 * @return 	boolean		true on success/false on failure
	 */
	public function save($id, $data, $ttl = 3600){
		$id = preg_replace('/\.cache/','',$id);
		return $this->_adapter->save($id.$this->_extension, $data, $ttl);
	}
	/**
	 * Delete from Cache
	 * @param 	mixed		unique identifier of the item in the cache
	 * @return 	boolean		true on success/false on failure
	 */
	public function delete($id){
		$id = preg_replace('/\.cache/','',$id);
		return $this->_adapter->delete($id.$this->_extension);
	}
	// ------------------------------------------------------------------------
	/**
	* Clean the cache
	* @return 	boolean		false on failure/true on success
	*/
	public function clean(){
		return $this->_adapter->clean();
	}
	// ------------------------------------------------------------------------
	/**
	* Cache Info
	* @param 	string		user/filehits
	* @return 	mixed		array on success, false on failure	
	*/
	public function cache_info($type = 'user'){
		return $this->_adapter->cache_info($type);
	}
	// ------------------------------------------------------------------------
	/**
	* Get Cache Metadata
	* @param 	mixed		key to get cache metadata on
	* @return 	mixed		return value from child method
	*/
	public function get_metadata($id){
		return $this->_adapter->get_metadata($id.$this->_extension);
	}
	// ------------------------------------------------------------------------
	/**
	* Initialize
	* Initialize class properties based on the configuration array.
	* @param	array 	
	* @return 	void
	*/
	private function _initialize($config){ 
	    $adapter  =  'Cache_'.(isset($config['adapter']) ? $config['adapter']: 'file');
        require_once DIR_INCLUDES.'/caching/drivers/'.$adapter.'.php';
		$this->_adapter = new $adapter($config);
        $default_config = array(
			'adapter',
			'memcached',
			'cache_path'
		);
       	foreach ($default_config as $key){
			if (isset($config[$key])){
				$param = '_'.$key;
				$this->_adapter->{$param} = $config[$key];
			}
		}
	}
	// ------------------------------------------------------------------------
	/**
	 * Is the requested driver supported in this environment?
	 * @param 	string	The driver to test.
	 * @return 	array
	 */
	public function is_supported(){  
        $support = $this->_adapter->is_supported();
		return $support;
	}
}