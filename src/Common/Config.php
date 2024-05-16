<?php
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 *
 */
/*
$table->unsignedBigInteger('config_id')->autoIncrement();
$table->string('config_name', 100)->nullable();
$table->longText('config_value')->nullable();
$table->unsignedTinyInteger('config_autoload')->default('0');

$table->index('config_id','config_id');
$table->index('config_name','config_name');
*/
namespace SQ\Common;

trait Config
{

	static function configAdd($name,$value,$is_autoload = 0){
		try {
			$config = \DB::table('config')->where('config_name', '=', $name)->first();

			if(!empty($config)){
				throw new \Exception("Config name sudah digunakan");
			}

			if(is_array($value)){
				$value = json_encode($value);
			}

			$in = [
				'config_name' => $name,
				'config_value' => $value,
				'config_autoload' => $is_autoload,
			];

			$configId = \DB::table('config')->insertGetId($in);


		} catch (\Throwable $e) {
			return $e->getMessage();
		}

		return true;
	}

	static function configUpdate($name,$value,$is_autoload = 0){

		try {
			$config = \DB::table('config')->where('config_name', '=', $name)->first();

			if(is_array($value)){
				$value = json_encode($value);
			}

			if(empty($config)){

				$in = [
					'config_name' => $name,
					'config_value' => $value,
					'config_autoload' => $is_autoload,
				];

				$configId = \DB::table('config')->insertGetId($in);
			} else {
				$up = [
					'config_value' => $value,
					'config_autoload' => $is_autoload,
				];
				\DB::table('config')->where('config_name', $name)->update($up);

			}

		} catch (\Throwable $e) {
			return $e->getMessage();
		}

		return true;
	}

	static function configGet($name){

		$config = \DB::table('config')->where('config_name', '=', $name)->first();

        if(empty($config)){
            return NULL;
        }

		if(isset($config->config_value)){
			if(isJson($config->config_value)){
				$config->config_value = json_decode($config->config_value);
			}
		}

		$nc = new \stdClass();
		$nc->id = $config->config_id;
		$nc->name = $config->config_name;
		$nc->value = $config->config_value;
		$nc->autoload = $config->config_autoload;
		return $nc;

	}

	static function configDelete($name){

		try {
			DB::table('config')->where('config_name', '=', $name)->delete();
		} catch (\Throwable $e) {
			return $e->getMessage();
		}

		return true;

	}
}
