<?php
$mw_cache_get_content_memory = array();





class MwCache {

	//$mw_cache_mem = array();
	function cache_get_content_from_memory($cache_id, $cache_group = false, $replace_with_new = false) {
		global $mw_skip_memory;
		static $mw_cache_mem = array();

		// return false;
		//static $mw_cache_mem = array();
		static $mw_cache_mem_hits = array();

		if (is_bool($cache_id) and $cache_id == true) {
			return $mw_cache_mem_hits;
		}

		$cache_id_o = $cache_id;

		//$cache_group = 'gr' . crc32($cache_group);
		// $cache_id = 'id' . crc32($cache_id);
		$mode = 2;
		switch ($mode) {
			case 0 :
				//experimental
				//$cache_group = (int) crc32($cache_group);
				//	$cache_id = 'compiled_caache'.(int) crc32($cache_id);

				$criteria_id = 'compiled_cache' . (int) crc32($cache_id); ;

				$cache_group_index = cache_get_file_path('index', $cache_group);

				$cache_content1 = CACHE_CONTENT_PREPEND;
				$mw_sep_for_index_cache = '_____|||||||||||||||-mw-sep-for-cache-file-|||||||||||||||_____';
				$mw_sep_for_cache_id = '-||-mw-sep-for-cache-id||--';

				if ($replace_with_new != false) {
					$mw_cache_mem[$cache_group][$cache_id] = $replace_with_new;

					if ($replace_with_new != false) {
						$cache_group_index = cache_get_file_path('index', $cache_group);

						if ($replace_with_new != false) {
							//	d($cache);
							file_put_contents($cache_group_index, $mw_sep_for_index_cache . $criteria_id . $mw_sep_for_cache_id . $replace_with_new, FILE_APPEND);
						}

					}

					//   asort($mw_cache_mem[$cache_group]);
					$mw_cache_mem_hits[$cache_group][$cache_id] = 1;

					// asort($mw_cache_mem);
				} else {

					if (!isset($mw_cache_mem[$cache_group][$cache_id])) {

						if (is_file($cache_group_index) == false) {
							file_put_contents($cache_group_index, $cache_content1);
						} else {
							$cache_group_index_file_contents = file_get_contents($cache_group_index);
							$cache_group_index_file_contents_array = explode($mw_sep_for_index_cache, $cache_group_index_file_contents);
							if (!empty($cache_group_index_file_contents_array)) {
								foreach ($cache_group_index_file_contents_array as $key => $value) {
									$compiled_cache = explode($mw_sep_for_cache_id, $value);
									if (!empty($compiled_cache)) {
										if (isset($compiled_cache[0]) and $compiled_cache[0] != '') {
											if (isset($compiled_cache[1]) and $compiled_cache[1] != false) {
												//	d($compiled_cache[0]);
												$mw_cache_mem[$cache_group][$compiled_cache[0]] = $compiled_cache[1];
												$mw_cache_mem_hits[$cache_group][$compiled_cache[0]] = 1;
											}
										}
									}
									// d($compiled_cache);

								}

								//
							}

						}
					}
				}

				if (isset($mw_cache_mem[$cache_group][$cache_id])) {
					$mw_cache_mem_hits[$cache_group][$cache_id]++;
					return $mw_cache_mem[$cache_group][$cache_id];
				} else {
					return false;
				}

				break;

			case 1 :
				//experimental
				if ($replace_with_new != false) {
					$mw_cache_mem[$cache_group][$cache_id] = $replace_with_new;
					//   asort($mw_cache_mem[$cache_group]);
					$mw_cache_mem_hits[$cache_group][$cache_id] = 1;
					// asort($mw_cache_mem);
				}

				if (isset($mw_cache_mem[$cache_group][$cache_id])) {
					$mw_cache_mem_hits[$cache_group][$cache_id]++;
					return $mw_cache_mem[$cache_group][$cache_id];
				} else {
					return false;
				}

				break;

			case 2 :
				$cache_group = (int) crc32($cache_group);
				$cache_id = (int) crc32($cache_id);

				$key = $cache_group + $cache_id;
				$key = intval($key);
				if ($replace_with_new != false) {
					$mw_cache_mem[$key] = $replace_with_new;

					$mw_cache_mem_hits[$cache_id_o] = 1;
					// ksort($mw_cache_mem);
					// ksort($mw_cache_mem_hits);
				}

				if (isset($mw_cache_mem[$key])) {

					$mw_cache_mem_hits[$cache_id_o]++;
					return $mw_cache_mem[$key];
				} else {
					return false;
				}

				break;

			default :
				break;
		}
	}

	function cache_file_memory_storage($path) {
		static $mem = array();
		$path_md = crc32($path);
		if (isset($mem["{$path_md}"]) != false) {
			return $mem[$path_md];
		}
		$cont = @ file_get_contents($path);
		$mem[$path_md] = $cont;
		return $cont;
	}

	function cache_get_file_path($cache_id, $cache_group = 'global') {
		$cache_group = str_replace('/', DIRECTORY_SEPARATOR, $cache_group);
		$f = cache_get_dir($cache_group) . DIRECTORY_SEPARATOR . $cache_id . CACHE_FILES_EXTENSION;

		return $f;
	}

	/**
	 *
	 *
	 * Deletes cache directory for given $cache_group recursively.
	 *
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 * @return boolean
	 * @author Peter Ivanov
	 * @since Version 1.0
	 */

	function cache_clean_group($cache_group = 'global') {
		// return true;
		//mw_notif(__FUNCTION__.$cache_group);
		$is_cleaning_now = mw_var('is_cleaning_now');
		$use_apc = false;
		if (APC_CACHE == true) {
			$apc_no_clear = mw_var('apc_no_clear');

			if ($apc_no_clear == false and $is_cleaning_now == false) {
				$apc_exists = function_exists('apc_clear_cache');
				if ($apc_exists == true) {
					apc_clear_cache('user');
					//d('apc_clear_cache');
				}
			} else {
				mw_var('is_cleaning_now', false);

			}
		}

		mw_var('is_cleaning_now', true);

		try {

			$recycle_bin_f = CACHEDIR . 'db' . DS . 'recycle_bin_clear_' . date("Ymd") . '.php';
			if (!is_file($recycle_bin_f)) {
				cache_clear_recycle();
				@touch($recycle_bin_f);
			}
			$cache_group_index = cache_get_file_path('index', $cache_group);
			//@rename($cache_group_index,$cache_group_index.rand());

			//	rename("/tmp/tmp_file.txt", "/home/user/login/docs/my_file.txt");

			// @unlink($cache_group_index);

			$dir = cache_get_dir('global');

			if (is_dir($dir)) {
				@recursive_remove_from_cache_index($dir);
			}
			$dir = cache_get_dir($cache_group);

			if (is_dir($dir)) {
				@recursive_remove_from_cache_index($dir);
			}
			mw_var('is_cleaning_now', false);
			// clearstatcache();
			return true;
		} catch (Exception $e) {
			return false;
			// $cache = false;
		}
	}

	/**
	 *
	 *
	 * Gets the full path cache directory for cache group
	 * Also seperates the group in subfolders for each 1000 cache files
	 * for performance reasons on huge sites.
	 *
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 * @return string
	 * @author Peter Ivanov
	 * @since Version 1.0
	 */
	function cache_get_dir($cache_group = 'global', $deleted_cache_dir = false) {
		$function_cache_id = false;
		$args = func_get_args();
		foreach ($args as $k => $v) {
			$function_cache_id = $function_cache_id . serialize($k) . serialize($v);
		}
		$function_cache_id = __FUNCTION__ . crc32($function_cache_id);
		$cache_content = 'CACHE_GET_DIR_' . $function_cache_id;

		if (!defined($cache_content)) {
			// define($cache_content, '1');
		} else {
			// var_dump(constant($cache_content));
			return (constant($cache_content));
		}

		if (strval($cache_group) != '') {
			$cache_group = str_replace('/', DIRECTORY_SEPARATOR, $cache_group);
			// we will seperate the dirs by 1000s
			$cache_group_explode = explode(DIRECTORY_SEPARATOR, $cache_group);
			$cache_group_new = array();
			foreach ($cache_group_explode as $item) {
				if (intval($item) != 0) {
					$item_temp = intval($item) / 1000;
					$item_temp = ceil($item_temp);
					$item_temp = $item_temp . '000';
					$cache_group_new[] = $item_temp;
					$cache_group_new[] = $item;
				} else {
					$cache_group_new[] = $item;
				}
			}
			$cache_group = implode(DIRECTORY_SEPARATOR, $cache_group_new);
			$cacheDir = CACHEDIR . $cache_group;

			if (!is_dir($cacheDir)) {
				mkdir_recursive($cacheDir);
			}

			if (!defined($cache_content)) {
				define($cache_content, $cacheDir);
			}

			return $cacheDir;
		} else {
			if (!defined($cache_content)) {
				define($cache_content, $cache_group);
			}

			return $cache_group;
		}
	}

	/**
	 *
	 *
	 *
	 * Gets encoded data from the cache as a string.
	 *
	 *
	 * @param string $cache_id
	 *        	of the cache
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 *
	 * @return string
	 * @author Peter Ivanov
	 * @since Version 1.0
	 */
	function cache_get_content_encoded($cache_id, $cache_group = 'global', $time = false) {

		//
		//    static $cache_index_array = array();
		//
		//    if (isset($cache_index_array[$cache_id])) {
		//        $cache_index_array[$cache_id]++;
		//        print $cache_index_array[$cache_id] . '<br>';
		//    } else {
		//        $cache_index_array[$cache_id] = 1;
		//    }

		if ($cache_group === null) {

			$cache_group = 'global';
		}

		if ($cache_id === null) {

			return false;
		}

		$use_apc = false;
		if (APC_CACHE == true) {
			$use_apc = true;
		}

		//$use_apc = false;

		if ($use_apc == true) {
			$quote = apc_fetch($cache_id);

			if ($quote) {

				return $quote;
			}
		}

		/* $function_cache_id = false;
		 $args = func_get_args ();
		 foreach ( $args as $k => $v ) {
		 $function_cache_id = $function_cache_id . serialize ( $k ) . serialize ( $v );
		 }
		 $function_cache_id = __FUNCTION__ . crc32 ( $function_cache_id );
		 $cache_content = 'CACHE_GET_CONTENT_' . $function_cacheok_id;

		 if (! defined ( $cache_content )) {
		 } else {

		 //	return (constant ( $cache_content ));
		 } */
		//
		// $cacheDir_index = CACHEDIR . 'rmindex' . DS;
		//    if (!is_arr($cache_index_array)) {
		//        $index_file = CACHEDIR . 'cache_index.php';
		//        if (is_file($index_file)) {
		//            $index_file_c = file_get_contents($index_file);
		//            $cache_index_array = explode(',', $index_file_c);
		//        }
		//    }

		$cache_id = trim($cache_id);

		$cache_group = $cache_group . DS;

		$cache_group = reduce_double_slashes($cache_group);
		if ($use_apc == false) {
			$mem = cache_get_content_from_memory($cache_id, $cache_group);
			//d($mem);
			if ($mem != false) {
				//d($cache_id);
				// exit();
				return $mem;
			}
		}

		$cache_file = cache_get_file_path($cache_id, $cache_group);
		$cache_file = normalize_path($cache_file, false);
		$get_file = $cache_file;

		//if (is_file($rm_f)) {
		//   @unlink($rm_f);
		//return false;
		// }

		$cache = false;
		try {

			if ($cache_file != false) {

				$is_cleaning_now = mw_var('is_cleaning_now');

				if ($is_cleaning_now == false and isset($get_file) == true and is_file($cache_file)) {

					// this is slower
					// $cache = implode('', file($cache_file));
					$cache = file_get_contents($cache_file);
					// this is slower

					// this is faster for sigle requests but spawns too much processes for 50req/sec
					/*
					 ob_start();
					 readfile($cache_file);

					 $cache = ob_get_contents();

					 ob_end_clean();
					 *
					 * */

				}
			}
		} catch (Exception $e) {
			$cache = false;
		}

		if (isset($cache) and strval($cache) != '') {

			$search = CACHE_CONTENT_PREPEND;

			$replace = '';

			$count = 1;

			$cache = str_replace($search, $replace, $cache, $count);
		}

		if (isset($cache) and $cache != false and ($cache) != '') {
			/*
			 if (! defined ( $cache_content )) {
			 if (strlen ( $cache_content ) < 50) {
			 define ( $cache_content, $cache );
			 }
			 } is */

			//gc_collect_cycles();
			if ($use_apc == false) {

				cache_get_content_from_memory($cache_id, $cache_group, $cache);
			} else {
				static $apc_apc_delete;
				if ($apc_apc_delete == false) {
					$apc_apc_delete = function_exists('apc_delete');
				}
				if ($apc_apc_delete == true and $use_apc == true) {
					apc_delete($cache_id);
				}

				if ($use_apc == true) {

					@apc_store($cache_id, $cache, APC_EXPIRES);
				}
			}
			return $cache;
		}

		/* 	if (! defined ( $cache_content )) {
		 //	define ( $cache_content, false );
		 } */
		return false;
	}

	/**
	 *
	 *
	 *
	 * Gets the data from the cache.
	 *
	 *
	 * Unserilaizer for the saved data from the cache_get_content_encoded() function
	 *
	 * @param string $cache_id
	 *        	of the cache
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 *
	 * @return mixed
	 * @author Peter Ivanov
	 * @since Version 1.0
	 * @uses cache_get_content_encoded
	 */

	//static $results_map_hits = array();

	function cache_get_content($cache_id, $cache_group = 'global', $time = false) {
		//

		$is_cl = mw_var('is_cleaning_now');
		if ($is_cl == true) {
			$is_cl = mw_var('is_cleaning_now', false);
			return false;
		}

		$mode = 2;

		if (!strstr($cache_group, 'global')) {
			$mode = 1;
		}

		$mode = 4;

		switch ($mode) {

			case 1 :
				//experimental
				global $mw_cache_get_content_memory;

				$criteria_id = 'cache_id_' . (int) crc32($cache_id . $cache_group);

				$cache_group_index = cache_get_file_path('index', $cache_group);

				$cache_content1 = CACHE_CONTENT_PREPEND;
				$mw_sep_for_index_cache = '_____|||||||||||||||-mw-sep-for-cache-file-|||||||||||||||_____';
				$mw_sep_for_cache_id = '-||-mw-sep-for-cache-id||--';
				if (!isset($mw_cache_get_content_memory[$criteria_id])) {

					if (is_file($cache_group_index) == false) {
						file_put_contents($cache_group_index, $cache_content1);
					} else {
						$cache_group_index_file_contents = file_get_contents($cache_group_index);
						$cache_group_index_file_contents_array = explode($mw_sep_for_index_cache, $cache_group_index_file_contents);
						if (!empty($cache_group_index_file_contents_array)) {
							foreach ($cache_group_index_file_contents_array as $key => $value) {
								$compiled_cache = explode($mw_sep_for_cache_id, $value);
								if (!empty($compiled_cache)) {
									if (isset($compiled_cache[0]) and $compiled_cache[0] != '') {
										if (isset($compiled_cache[1]) and $compiled_cache[1] != false) {
											$mw_cache_get_content_memory[$compiled_cache[0]] = $compiled_cache[1];
										}
									}
								}
								//d($compiled_cache);

							}

							//
						}

					}
				}
				// 	d(           ($cache_group_index));

				if (isset($mw_cache_get_content_memory[$criteria_id])) {
					$cache = $mw_cache_get_content_memory[$criteria_id];
					//$results_map_hits[$criteria_id]++;
				} else {
					$is_cleaning_now = mw_var('is_cleaning_now');
					$cache = cache_get_content_encoded($cache_id, $cache_group, $time);
					$mw_cache_get_content_memory[$criteria_id] = $cache;
					if ($cache != false and $is_cleaning_now == false) {
						//	d($cache);
						file_put_contents($cache_group_index, $mw_sep_for_index_cache . $criteria_id . $mw_sep_for_cache_id . $cache, FILE_APPEND);
					}
				}

				break;

			case 2 :
				//experimental
				global $mw_cache_get_content_memory;

				//	$criteria_id = (int) crc32($cache_id . $cache_group);
				$criteria_id = ($cache_id);
				if (isset($mw_cache_get_content_memory[$criteria_id])) {
					$cache = $mw_cache_get_content_memory[$criteria_id];
					//$results_map_hits[$criteria_id]++;
				} else {
					$cache = cache_get_content_encoded($cache_id, $cache_group, $time);
					$mw_cache_get_content_memory[$criteria_id] = $cache;
				}

				break;

			default :
				$cache = cache_get_content_encoded($cache_id, $cache_group, $time);
				break;
		}

		if ($cache == '' or $cache == '---empty---' or $cache == '---false---') {

			return false;
		} else {
			//   $cache = base64_decode($cache);
			$cache = unserialize($cache);

			return $cache;
		}
	}

	/**
	 *
	 *
	 * Stores your data in the cache.
	 * It can store any value, such as strings, array, objects, etc.
	 *
	 * @param mixed $data_to_cache
	 *        	your data
	 * @param string $cache_id
	 *        	of the cache, you must define it because you will use it later to
	 *        	load the file.
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 *
	 * @return boolean
	 * @author Peter Ivanov
	 * @since Version 1.0
	 * @uses cache_write_to_file
	 */

	function cache_save($data_to_cache, $cache_id, $cache_group = 'global') {
		if (mw_var('is_cleaning_now') == true) {
			return false;
		}

		if ($data_to_cache == false) {

			return false;
		} else {
			$data_to_cache = serialize($data_to_cache);

			cache_write_to_file($cache_id, $data_to_cache, $cache_group);

			return true;
		}
	}

	function cache_write($data_to_cache, $cache_id, $cache_group = 'global') {
		return cache_write_to_file($cache_id, $data_to_cache, $cache_group);
	}

	/**
	 * Writes the cache file in the CACHEDIR directory.
	 *
	 * @param string $cache_id
	 *        	of the cache
	 * @param string $content
	 *        	content for the file, must be a string, if you want to store
	 *        	object or array, please use the cache_save() function
	 * @param string $cache_group
	 *        	(default is 'global') - this is the subfolder in the cache dir.
	 *
	 * @return string
	 * @author Peter Ivanov
	 * @since Version 1.0
	 * @see cache_save
	 */
	function cache_get_index_file_path($cache_group) {
		$cache_group_clean = explode("/", $cache_group);
		if (isset($cache_group_clean[0])) {
			$cache_group_clean = "cache_index_" . $cache_group_clean[0];
		} else {
			$cache_group_clean = "cache_index_global";
		}

		$cache_group_index = CACHEDIR . $cache_group_clean . '.php';
		return $cache_group_index;
	}

	function cache_write_to_file($cache_id, $content, $cache_group = 'global') {

		$is_cleaning = mw_var('is_cleaning_now');

		if (strval(trim($cache_id)) == '' or $is_cleaning == true) {

			return false;
		}

		$cache_file = cache_get_file_path($cache_id, $cache_group);
		$cache_file = normalize_path($cache_file, false);

		if (strval(trim($content)) == '') {

			return false;
		} else {
			$cache_index = CACHEDIR . 'index.php';

			$cache_content1 = CACHE_CONTENT_PREPEND;

			if ($cache_content1) {

				if (is_file($cache_index) == false) {
					//file_put_contents($cache_index, $cache_content1);
					touch($cache_index);
				}

			}

			$see_if_dir_is_there = dirname($cache_file);

			$content1 = CACHE_CONTENT_PREPEND . $content;
			// var_dump ( $cache_file, $content );
			if (is_dir($see_if_dir_is_there) == false) {
				mkdir_recursive($see_if_dir_is_there);
			}
			try {
				$is_cleaning_now = mw_var('is_cleaning_now');

				if ($is_cleaning_now == false) {
					$cache_file_temp = $cache_file . '.tmp' . rand() . '.php';
					$cache = file_put_contents($cache_file_temp, $content1);
					@rename($cache_file_temp, $cache_file);

				}

			} catch (Exception $e) {
				// $this -> cache_storage[$cache_id] = $content;
				$cache = false;
			}
		}

		return $content;
	}

	function cache_clear_recycle() {
		return true;
		static $recycle_bin;

		if ($recycle_bin == false) {
			$recycle_bin = CACHEDIR . '_recycle_bin' . DS;
			if (is_dir($recycle_bin)) {
				recursive_remove_directory($recycle_bin, false);
			}
		}
	}

	function clearcache() {
		if (MW_IS_INSTALLED == false) {

			recursive_remove_from_cache_index(CACHEDIR, true);
			return true;
		}
		if (is_admin() == false) {
			error('Error: not logged in as admin.'.__FILE__.__LINE__);
		}

		recursive_remove_from_cache_index(CACHEDIR, true);

		recursive_remove_from_cache_index(CACHEDIR_ROOT, true);
		return true;
	}

	function recursive_remove_from_cache_index($directory, $empty = true) {
		mw_var('is_cleaning_now', true);
		static $recycle_bin;

		//   if ($recycle_bin == false) {
		//       $recycle_bin = CACHEDIR . '_recycle_bin' . DS . date("Y-m-d-H") . DS;
		//       if (!is_dir($recycle_bin)) {
		//           mkdir_recursive($recycle_bin, false);
		//           @touch($recycle_bin . 'index.php');
		//           @touch(CACHEDIR . '_recycle_bin' . DS . 'index.php');
		//       }
		//   }
		recursive_remove_directory($directory);
		foreach (glob($directory, GLOB_ONLYDIR + GLOB_NOSORT) as $filename) {

			//@rename($filename, $recycle_bin . '_pls_delete_me_' . mt_rand(1, 99999) . mt_rand(1, 99999));
		}
		mw_var('is_cleaning_now', false);
		return true;

		// if the path has a slash at the end we remove it here
		if (substr($directory, -1) == DIRECTORY_SEPARATOR) {

			$directory = substr($directory, 0, -1);
		}

		// if the path is not valid or is not a directory ...
		if (!file_exists($directory) || !is_dir($directory)) {

			// ... we return false and exit the function
			return FALSE;

			// ... if the path is not readable
		} elseif (!is_readable($directory)) {

			// ... we return false and exit the function
			return FALSE;

			// ... else if the path is readable
		} else {

			// we open the directory
			$handle = opendir($directory);

			// and scan through the items inside
			while (FALSE !== ($item = readdir($handle))) {

				// if the filepointer is not the current directory
				// or the parent directory
				if ($item != '.' && $item != '..') {

					// we build the new path to delete
					$path = $directory . DIRECTORY_SEPARATOR . $item;

					// if the new path is a directory
					if (is_dir($path)) {
						// we call this function with the new path
						//recursive_remove_from_cache_index($path);
						// if the new path is a file
					} else {
						$path = normalize_path($path, false);
						try {
							rename($path, $recycle_bin . '_pls_delete_me_' . mt_rand(1, 99999) . mt_rand(1, 99999)) . '.php';
							//    $path_small = crc32($path);
							//file_put_contents($index_file, $path_small . ",", FILE_APPEND);
							// rename($index_file_rand, $index_file);
							//  d($path);
							//  unlink($path);
						} catch (Exception $e) {

						}
					}
				}
			}

			// close the directory
			closedir($handle);

			// if the option to empty is not set to true
			if ($empty == FALSE) {

				// try to delete the now empty directory
				if (!rmdir($directory)) {

					// return false if not possible
					return FALSE;
				}
			}

			// return success
			return TRUE;
		}
	}

}
