<?php 
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace SQ\Common;

trait Query
{

    static $defaultLimit = 999999999;

    static function DB(){
        $db = new \DB;
        return $db;
    }

    static function queryResult($query,$column = ['*']){
        $arr = $query->get($column)->toArray();

        $nd = [];
        if(!empty($arr) && isset($arr[0])){
            foreach ($arr as $key => $v) {
                $nd[] = (array)$v;
            }
        }
        return $nd;
    }

    static function queryResultRow($query,$column = ['*']){
        return $query->first($column);
    }

    static function queryResultRowArray( $query,$column = ['*']){
        return (array)$query->first($column);
    }

    static function queryPaginateCustom($total, $pagenum, $limit){
        $total_page = ceil($total / $limit);

        //------------- Prev page
        $prev = $pagenum - 1;
        if ($prev < 1) {
            $prev = 0;
        }
        //------------------------

        //------------- Next page
        $next = $pagenum + 1;
        if ($next > $total_page) {
            $next = 0;
        }
        //----------------------

        $from = 1;
        $to = $total_page;

        $to_page = $pagenum - 2;
        if ($to_page > 0) {
            $from = $to_page;
        }

        if ($total_page >= 5) {
            if ($total_page > 0) {
                $to = 5 + $to_page;
                if ($to > $total_page) {
                    $to = $total_page;
                }
            } else {
                $to = 5;
            }
        }

        #looping kotak pagination
        $firstpage_istrue = false;
        $lastpage_istrue = false;
        $detail = [];
        if ($total_page <= 1) {
            $detail = [];
        } else {
            for ($i = $from; $i <= $to; $i++) {
                $detail[] = $i;
            }
            if ($from != 1) {
                $firstpage_istrue = true;
            }
            if ($to != $total_page) {
                $lastpage_istrue = true;
            }
        }

        $total_display = 0;
        if ($pagenum < $total_page) {
            $total_display = $limit;
        }
        if ($pagenum == $total_page) {
            if(($total % $limit) != 0){
                $total_display = $total % $limit;
            }else{
                $total_display = $limit;
            }
        }
        if($limit == static::$defaultLimit){
            $limit = $total;
        }
        $pagination = array(
            'total_data' => $total,
            'total_page' => $total_page,
            'total_display' => $total_display,
            'first_page' => $firstpage_istrue,
            'last_page' => $lastpage_istrue,
            'prev' => $prev,
            'current' => $pagenum,
            'limit' => (int)$limit,
            'next' => $next,
            'detail' => $detail
                // 'detail' => json_encode($detail)
        );

        return $pagination;
    }

    static function queryPaginateGenerate($res, $laravel = false){

        if($laravel === true){

            if($res->perPage() == static::$defaultLimit){
                $limit = $res->total();
            }

            $showPage = 5;
            $pagination['count'] = $res->count();
            $pagination['currentPage'] = $res->currentPage();
            $pagination['firstItem'] = emptyVal($res->firstItem(),0);
            $pagination['hasPages'] = $res->hasPages();
            $pagination['hasMorePages'] = $res->hasMorePages();
            $pagination['lastItem'] = emptyVal($res->lastItem(),0);
            $pagination['lastPage'] = $res->lastPage();
            $pagination['nextPageUrl'] = emptyVal($res->nextPageUrl(),'');
            $pagination['onFirstPage'] = $res->onFirstPage();
            $pagination['perPage'] = $res->perPage();
            $pagination['previousPageUrl'] = emptyVal($res->previousPageUrl());
            $pagination['total'] = $res->total();
            $pagination['getPageName'] = $res->getPageName();
            $pagination['showPage'] = $showPage;

            $from = $res->currentPage();
            $to = $from + $pagination['showPage'] - 1;
            $end = $res->lastPage();
            $detail = [];

            if ($res->total() <= 1) {
                $detail = [];
            } else {
                for ($i = $from; $i <= $to; $i++) {
                    if($end >= $i){
                        $detail[] = $i;
                    }
                }
            }
            $pagination['pages'] = $detail;
            return $pagination;

        } else {

            $queryPaginateCustom = self::queryPaginateCustom($res->total(), $res->currentPage(), $res->perPage());
            return $queryPaginateCustom;
        }
    }

    /* get data db aftart DB:table()*/
    static function &setQueryPaginate($query = '',$conf = []){
        static $dataQuery = [];

        if(!empty($query)){
            $dataQuery['query'] = $query;
            $dataQuery['conf'] = $conf;
        }
        return $dataQuery;
    }

    static function getQueryPaginate(){
        return self::setQueryPaginate()['query'];
    }

    static function confQueryPaginate(){
        return self::setQueryPaginate()['conf'];
    }


    static function resetQueryPaginate(){
        return self::setQueryPaginate()['query'] = '';
    }

    static function queryPaginateRresult($paginate = true){
        $conf = self::confQueryPaginate();
        $query = self::getQueryPaginate();

        $req = request()->all();
        $default_conf = [
            'select' => ['*'],
            'search' => [],
            'columns' => [],
            'columns_as' => [],
            'query_type' => '',
        ];

        $default = [
            'limit' => 10,
            'order_by' => 'DESC',
            'sort' => '',
            'search' => '',
        ];

        $data_default = [
            'order_by' => ['asc','desc'],
        ];

        $conf = array_merge($default_conf,$conf);

        foreach ($conf as $k => $v) {
            if(empty($v)){
                $conf[$k] = $default_conf[$k];
            }
        }


        $req = array_merge($default,$req);

        foreach ($req as $k => $v) {
            if(empty($v)){
                if(isset($default[$k])){
                    $req[$k] = $default[$k];
                }
            }
        }

        if(!is_numeric($req['limit'])){
            $req['limit'] = $default['limit'];
        }

        if($req['limit'] == -1){
            $req['limit'] = static::$defaultLimit;
        }


        $columns = [];
        foreach ($conf['select'] as $key => $v) {
            $v = trim($v);
            if (strpos($v, ' as ') !== false) {
                $vArr = explode(' as ', $v);
                $v = trim($vArr[1]);
                $conf['columns_as'][$v] = trim($vArr[0]);
            }
            $columns[] = $v;
        }; 

        if(count($columns) == 1 && isset($columns[0]) && $columns[0] == '*'){
        } else {
            $conf['columns'] = $columns;
        }

        self::setQueryPaginate()['conf'] = $conf;

        if(!empty($conf['columns'])){
            $query->where(function($query){
                self::filterQuery();
            });
        }


        if(!empty($conf['search']) && !empty($req['search'])){
            $query->where(function ($query) use ($req) {
                $conf = self::confQueryPaginate();
                foreach ($conf['search'] as $key => $v) {
                    $v = issetVal($conf['columns_as'],$v,$v);
                    $query->orWhere($v, 'LIKE', "%{$req['search']}%");
                }
            });
        }

        if(!empty($conf['columns'])){
            if(is_array($req['sort']) && !empty($req['sort'])){
                foreach ($req['sort'] as $k => $v) {
                    if(in_array($k, $conf['columns']) && in_array(strtolower($v),$data_default['order_by'])){
                        $k = issetVal($conf['columns_as'],$k,$k);
                        $query->orderBy($k, $v); 
                    }
                }

            } else {
                if(empty($req['sort'])){
                    $req['sort'] = issetVal($conf['columns_as'],$conf['columns'][0],$conf['columns'][0]);
                }

                if(in_array($req['sort'], $conf['columns']) && in_array(strtolower($req['order_by']),$data_default['order_by'])){
                    $req['sort'] = issetVal($conf['columns_as'],$req['sort'],$req['sort']);
                    $query->orderBy($req['sort'], $req['order_by']);
                }
            }
        }

        $data_list = $query->paginate($req['limit'],$conf['select']);

        $nd = [];
        if(!empty($data_list->items())){
            foreach ($data_list->items() as $key => $v) {
                $nd[] = $v;
            }
        }

        $content['data_list'] = $nd;
        $content['pagination'] = self::queryPaginateGenerate($data_list, false);
        return $content;
    }

    static function filterQueryArray()
    {

        $req = request()->all();
        $query = self::getQueryPaginate();
        $conf = self::confQueryPaginate();

        $where_filter = $req['filter'];
        $field_allowed = $conf['columns'];

        $sql_search = '';

        if ($where_filter != null) {
            foreach ($where_filter as $row) {
                $type = isset($row['type']) ? $row['type'] : '';
                $field = isset($row['field']) ? $row['field'] : '';
                $value = isset($row['value']) ? $row['value'] : '';
                $comparison = isset($row['comparison']) ? $row['comparison'] : '';

                if (!in_array($field, $field_allowed)) {
                    $field = '';
                }

                if ($field === '' || $value === '') {
                    $type = '';
                }

                switch ($type) {
                    case 'string':
                    $arr_allowed = array('=', '<', '>', '<>', '!=');
                    if (!in_array($comparison, $arr_allowed)) {
                        $comparison = '=';
                    }
                    switch ($comparison) {
                        case '=':
                        $sql_search .= " AND " . $field . " = '" . $value . "'";
                        break;
                        case '!=':
                        $sql_search .= " AND " . $field . " != '" . $value . "'";
                        break;
                        case '<':
                        $sql_search .= " AND " . $field . " LIKE '" . $value . "%'";
                        break;
                        case '>':
                        $sql_search .= " AND " . $field . " LIKE '%" . $value . "'";
                        break;
                        case '<>':
                        $sql_search .= " AND " . $field . " LIKE '%" . $value . "%'";
                        break;
                    }
                    break;
                    case 'numeric':
                    if (is_numeric($value)) {
                        $arr_allowed = array('=', '<', '>', '<=', '>=', '<>');
                        if (!in_array($comparison, $arr_allowed)) {
                            $comparison = '=';
                        }
                        $sql_search .= " AND " . $field . " " . $comparison . " " . $value;
                    }
                    break;
                    case 'list':
                    if (strstr($value, '::')) {
                        $arr_allowed = array('yes', 'no', 'bet');
                        if (!in_array($comparison, $arr_allowed)) {
                            $comparison = 'yes';
                        }
                        $fi = explode('::', $value);
                        for ($q = 0; $q < count($fi); $q++) {
                            $fi[$q] = "'" . $fi[$q] . "'";
                        }
                        $value = implode(',', $fi);
                        if ($comparison == 'yes') {
                            $sql_search .= " AND " . $field . " IN (" . $value . ")";
                        }
                        if ($comparison == 'no') {
                            $sql_search .= " AND " . $field . " NOT IN (" . $value . ")";
                        }
                        if ($comparison == 'bet') {
                            $sql_search .= " AND " . $field . " BETWEEN " . $fi[0] . " AND " . $fi[1];
                        }
                    } else {
                        $sql_search .= " AND " . $field . " = '" . $value . "'";
                    }
                    break;
                    case 'date':
                    if (endWith($field, 'date')) {
                        $value1 = '';
                        $value2 = '';
                        if (strstr($value, '::')) {
                            $date_value = explode('::', $value);
                            $value1 = $date_value[0];
                            $value2 = $date_value[1];
                        } else {
                            $value1 = $value;
                        }

                        $arr_allowed = array('=', '<', '>', '<=', '>=', '<>', 'bet');
                        if (!in_array($comparison, $arr_allowed)) {
                            $comparison = '=';
                        }
                        if ($comparison == 'bet') {
                            if (Data::validate_date($value1) && Data::validate_date($value2)) {
                                $sql_search .= " AND " . $field . " BETWEEN '" . $value1 . "' AND '" . $value2 . "'";
                            }
                        } else {
                            if (Data::validate_date($value1)) {
                                $sql_search .= " AND " . $field . " " . $comparison . " '" . $value1 . "'";
                            }
                        }
                    }
                    if (endWith($field, 'datetime')) {
                        $value1 = '';
                        $value2 = '';
                        if (strstr($value, '::')) {
                            $date_value = explode('::', $value);
                            $value1 = $date_value[0];
                            $value2 = $date_value[1];
                        } else {
                            $value1 = $value;
                        }

                        $arr_allowed = array('=', '<', '>', '<=', '>=', '<>', 'bet');
                        if (!in_array($comparison, $arr_allowed)) {
                            $comparison = '=';
                        }
                        if ($comparison == 'bet') {
                            if (Data::validate_date($value1, 'Y-m-d H:i:s') && Data::validate_date($value2, 'Y-m-d H:i:s')) {
                                $sql_search .= " AND " . $field . " BETWEEN '" . $value1 . "' AND '" . $value2 . "'";
                            }else if (Data::validate_date($value1) && Data::validate_date($value2)) {
                                $sql_search .= " AND DATE(" . $field . ") BETWEEN '" . $value1 . "' AND '" . $value2 . "'";
                            }
                        } else {
                            if (Data::validate_date($value1, 'Y-m-d H:i:s')) {
                                $sql_search .= " AND " . $field . " " . $comparison . " '" . $value1 . "'";
                            }else if (Data::validate_date($value1)) {
                                $sql_search .= " AND DATE(" . $field . ") " . $comparison . " '" . $value1 . "'";
                            }
                        }
                    }
                    break;
                }
            }
        }
        if(!empty($sql_search)){
            $query->whereRaw(substr($sql_search, 4));
        }
    }


    static function filterQuery()
    {
        $req = request()->all();
        $query = self::getQueryPaginate();
        $conf = self::confQueryPaginate();

        if (isset($req['filter']) && !empty($req['filter'])) {
            self::filterQueryArray($req['filter']);
        }

        foreach ($req as $field => $value) {
            if (in_array($field, $conf['columns'])) {
                $field = issetVal($conf['columns_as'],$field,$field);
                if (is_array($value)) {
                    foreach ($value as $comparison => $val) {
                        if ($val !== '') {
                            switch ($comparison) {
                                case 'eq':
                                $query->where($field,'=',$val);
                                break;

                                case 'neq':
                                $query->where($field,'!=',$val);
                                break;

                                case 'lt':
                                $query->where($field,'<',$val);
                                break;

                                case 'gt':
                                $query->where($field,'>',$val);
                                break;

                                case 'lte':
                                $query->where($field,'<=',$val);
                                break;

                                case 'gte':
                                $query->where($field,'>=',$val);
                                break;

                                case 'le':
                                $query->where($field,'like',"$val%");
                                break;

                                case 'ls':
                                $query->where($field,'like',"%$val");
                                break;

                                case 'lse':
                                $query->where($field,'like',"%$val%");
                                break;

                                case 'in':
                                $query->whereIn($field,$val);
                                break;

                                case 'nin':
                                $query->whereNotIn($field,$val);
                                break;
                            }
                        }
                    }
                } else {
                    if ($value !== '') {
                        $query->where($field,'=',$value);
                    }
                }
            }
        }
        return $query;
    }

    /* MIGRATION */
    static function migrationSetSqlMode(){
        \DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
    }

    static function migrationSetTable($table){
        self::migrationSetSqlMode();
        $table->engine = 'InnoDB';
        $table->charset = 'utf8mb4';
        $table->collation = 'utf8mb4_unicode_520_ci';
    }


    static function generateSlug($table,$table_field, $string_data, $unique_identify){

        $makeSlug = Url::slug($string_data);
        $slugExist = true;
        $slugnum = 0;
        while ($slugExist) {
            $data = \DB::table($table)->where($table_field, '=', $makeSlug)->first();
            if(!empty($data)){
                $slugnum++;
                $sl = explode('-', $makeSlug);
                if(is_numeric(end($sl)) && count($sl) > 1){
                    array_pop($sl);
                }
                $makeSlug = implode('-',$sl);
                $makeSlug =  $makeSlug .'-'. $unique_identify;
                $slugExist = true;
                if($makeSlug == $data->{$table_field}){
                    $slugExist = false;
                } 
            } else {
                $slugExist = false;
            }

        }
        return $makeSlug;
    }

    static function generateInvoiceCode($table,$table_field_invoice, $table_field_id, $table_field_date, $custom_landig_prefix='',$landing_zero_count=''){
        $date_formated = date('Y-m-d');
        $date_text = date('Ymd');
        if(empty($landing_zero_count)){
            $landing_zero_count = 6;
        }
        $count_data_invoice = \DB::table($table)->whereDate($table_field_date, '=', $date_formated)->count();
        $count_data_invoice++;
        
        $invoiceExist = true;
        while ($invoiceExist) {

            $inv_data_count = sprintf("%0".$landing_zero_count."d", $count_data_invoice);

            $makeInvoice = $custom_landig_prefix . $date_text.$inv_data_count;
            
            $data = \DB::table($table)->where($table_field_invoice, '=', $makeInvoice)->orderBy($table_field_id, 'DESC')->first();

            if(!empty($data)){
                $count_data_invoice++;
                
                $makeInvoice =  $makeInvoice;
                $invoiceExist = true;
                if($makeInvoice == $data->{$table_field_invoice}){
                    $invoiceExist = false;
                } 
            } else {
                $invoiceExist = false;
            }

        }
        return $makeInvoice;
    }

    static function queryDeleteMsg($arrId, $textMsg){
        $msg = [];
        foreach ($arrId as $v) {
            $nv = [];
            $nv['id'] = $v;
            $nv['msg'] = $textMsg;
            $msg[] = $nv;
        }
        return $msg;
    }
}