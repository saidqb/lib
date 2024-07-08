<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 *
 */

namespace Saidqb\Lib\Common;

use Saidqb\Lib\Support\ResponseCode;
use Saidqb\Lib\Support\Helper;

trait Api
{
    static $responseJsonDecode = array();
    static $responseFilterConfig = array();

    static function responseDecodeFor($arr = [])
    {
        static::$responseJsonDecode = $arr;
    }

    static function responseConfig($arr = [])
    {
        $default = [
            'hide' => [],
            'decode' => [],
            'decode_child' => [],
            'decode_array' => [],
            'set_default_field' => [],
            'add_field' => [],
            'hook' => [],
        ];

        $rArr = array_merge($default, $arr);
        static::$responseFilterConfig = $rArr;
    }

    static function responseConfigAdd($config, $value = [])
    {
        static::$responseFilterConfig[$config] = $value;
    }

    static function responseAddField($field, $value = '')
    {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                static::$responseFilterConfig['add_field'][$k] = $v;
            }
            return true;
        }
        static::$responseFilterConfig['add_field'][$field] = $value;
        return true;
    }

    static function filterResponseField($arr)
    {
        $nv = [];
        if (is_string($arr)) {
            return $nv;
        }

        if (!empty($arr)) {
            foreach ($arr as $kv => $v) {

                if (!empty(static::$responseFilterConfig['hide'])) {
                    if (in_array($kv, static::$responseFilterConfig['hide'])) continue;
                }

                if (!empty(static::$responseFilterConfig['decode'])) {

                    if (in_array($kv, static::$responseFilterConfig['decode'])) {
                        if (!empty($v) && Helper::isJson($v)) {
                            $nv[$kv] = json_decode($v);

                            if (!empty(static::$responseFilterConfig['decode_child'])) {
                                foreach (static::$responseFilterConfig['decode_child'] as $kdc => $vdc) {
                                    if (strpos($vdc, '.') !== false) {
                                        $childv = explode('.', $vdc);
                                        if ($kv == $childv[0]) {
                                            if (isset($nv[$kv]->{$childv[1]})) {
                                                $nv[$kv]->{$childv[1]}  = (empty($nv[$kv]->{$childv[1]})) ? (object)null : $nv[$kv]->{$childv[1]};
                                            }
                                        }
                                    }
                                }
                            }
                        } else if (is_array($v)) {
                            $nv[$kv] = (empty($v)) ? (object)null : $v;
                        } else {
                            $nv[$kv] = (object) null;
                        }
                        continue;
                    }
                }

                if (!empty(static::$responseFilterConfig['decode_array'])) {
                    if (in_array($kv, static::$responseFilterConfig['decode_array'])) {
                        if (!empty($v) && Helper::isJson($v)) {
                            $nv[$kv] = json_decode($v);
                        } else if (is_array($v)) {
                            $nv[$kv] = $v;
                        } else {
                            $nv[$kv] = array();
                        }
                        continue;
                    }
                }
                if (in_array($kv, static::$responseJsonDecode)) {
                    $nv[$kv] = json_decode($v);
                    continue;
                }


                if (is_null($v) || $v === NULL) {
                    $v = '';
                }

                $nv[$kv] = $v;
            }


            if (!empty(static::$responseFilterConfig['set_default_field'])) {
                $fieldfirst = array_keys(static::$responseFilterConfig['set_default_field']);
                foreach ($fieldfirst as $k => $v) {
                    if (isset($nv[$v])) {
                        $nv[$v] = Manipulation::arrayMergeMultiChild(static::$responseFilterConfig['set_default_field'][$v], $nv[$v]);
                    }
                }
            }


            if (!empty(static::$responseFilterConfig['add_field'])) {
                foreach (static::$responseFilterConfig['add_field'] as $k => $v) {
                    $nv[$k] = $v;
                }
            }

            if (!empty(static::$responseFilterConfig['hook'])) {
                foreach (static::$responseFilterConfig['hook'] as $k => $v) {
                    if (is_callable(static::$responseFilterConfig['hook'][$k])) {

                        $nv = call_user_func(static::$responseFilterConfig['hook'][$k], $nv);
                    }
                }
            }
        }

        return $nv;
    }

    /**
     * [response display response api]
     * @param  [int] $code         	[kode response]
     * @param  string $data         [data array or json or [data=>] [data_list=>]]
     * @param  string $message      [pesan error or sukses]
     * @param  string $message_code [kode ke dua pada response kode yang sama]
     * @return [type]               [description]
     */
    static function response($code, $data = '', $message = '', $message_code = '')
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        $is_success = 0;
        if ($code == ResponseCode::HTTP_OK) {
            $is_success = 1;
        }
        $content = [
            'code' => $code,
            'success' => $is_success,
            'message' => $message,
        ];

        if (!empty($message_code)) {
            $content['message_code'] = $message_code;
        }

        if (isset($data['data_list'])) {
            $nd = $data['data_list'];
            if (!empty($data['data_list'])) {
                $nd = [];
                foreach ($data['data_list'] as $k => $v) {
                    $nd[] = self::filterResponseField($v);
                }
            }
            $content['data'] = $nd;
            unset($data['data_list']);

            if (isset($data['pagination'])) {
                $content['pagination'] = $data['pagination'];
            }

            if (is_string($content['data']) && !empty($content['data'])) {
                $content['message'] = $content['data'];
                $content['data'] = [];
            } else {
                $content['data'] = Helper::emptyVal($content['data'], []);
            }
        } else if (($data == 'data_list') || isset($data[0]) && is_array($data) && in_array('data_list', $data)) {
            $content['data'] = [];
        } else {
            if (isset($data['data'])) {
                $data = $data['data'];
            }

            if (is_string($data) && !empty($data)) {
                $content['message'] = $data;
                $content['data'] = (object) null;
            } else {
                $nd = $data;
                if ($code == ResponseCode::HTTP_OK) {
                    $nd = self::filterResponseField($data);
                }
                $content['data'] = Helper::emptyVal($nd, (object) null);
            }
        }

        if (!in_array($code, [ResponseCode::HTTP_OK, ResponseCode::HTTP_BAD_REQUEST, ResponseCode::HTTP_VALIDATION_ERROR, ResponseCode::HTTP_NOT_FOUND])) {
            unset($content['data']);
        }

        if ($code == ResponseCode::HTTP_VALIDATION_ERROR) {
            $content_data = $content['data'];
            $content_data = (array)$content_data;
            if (!empty($content_data)) {
                $set_validation_error = array_values($content_data);
                if (isset($set_validation_error[0][0])) {
                    $content['message'] = $set_validation_error[0][0];
                }
            }
        }

        return response($content, ResponseCode::HTTP_OK);
    }


    static function dataNormalize($data)
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        if (isset($data['data_list'])) {
            $nd = $data['data_list'];
            if (!empty($data['data_list'])) {
                $nd = [];
                foreach ($data['data_list'] as $k => $v) {
                    $nd[] = self::filterResponseField($v);
                }
            }
            $content['data'] = $nd;
            unset($data['data_list']);

            if (isset($data['pagination'])) {
                $content['pagination'] = $data['pagination'];
            }

            if (is_string($content['data']) && !empty($content['data'])) {
                $content['data'] = [];
            } else {
                $content['data'] = Helper::emptyVal($content['data'], []);
            }
        } else if (($data == 'data_list') || isset($data[0]) && is_array($data) && in_array('data_list', $data)) {
            $content['data'] = [];
        } else {
            if (isset($data['data'])) {
                $data = $data['data'];
            }

            if (is_string($data) && !empty($data)) {
                $content['data'] = (object) null;
            } else {
                $nd = $data;
                $nd = self::filterResponseField($data);
                $content['data'] = Helper::emptyVal($nd, (object) null);
            }
        }

        return $content['data'];
    }


    static function requestJson($key)
    {
        $req = request()->all();

        $json = Helper::issetVal($req, $key, '{}');

        if (is_array($json)) {
            return json_encode($json);
        }

        if (!Helper::isJson($json)) {
            $json = '{}';
        }
        return $json;
    }

    static function requestJsonArray($key)
    {
        $req = request()->all();

        $json = Helper::issetVal($req, $key, '[]');

        if (is_array($json)) {
            return json_encode($json);
        }

        if (!Helper::isJson($json)) {
            $json = '[]';
        }
        return $json;
    }

    static function customKeyStart($err, $text, $sep = '.')
    {
        $new = [];
        if (empty($err)) {
            return $new;
        }
        foreach ($err as $key => $v) {
            $new[$text . $sep . $key] = $v;
        }
        return $new;
    }

}
