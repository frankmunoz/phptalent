<?php
class HelperString {
    public static function strPosition($haystack, $needle, $offset = 0)
    {
        $count = HelperString::strLength($needle);
        $countHaystack = HelperString::strLength($haystack);
    
        if ($offset < 0) {
            return false;
        }
        
        $start = false;
        for ($i = 0; $i < $count; $i++) {
            $innerCount = 0;
            for ($o = $offset; $o < $countHaystack; $o++) {
                $symbol = $needle[$i];
                $hSymbol = $haystack[$o];
                if ($symbol === $hSymbol) {
                    $i++;
                    $start = $o;
                    $innerCount++;
                    if ($innerCount === $count) {
                        break 2;
                    }
                } else {
                    $start = false;
                }
            }
        }
        
        if ($start !== false) {
            $start = $start - ($count - 1);
        }

        return $start;
    }

    public static function strLength($string)
    {
        $i = 0;
        while (true) {
            if (isset($string[$i])) {
                $i++;
            } else {
                break;
            }
        }

        return $i;
    }

    public static function array_msort($obj, $cols)
    {
        $colarr = array();
        $array = json_decode(json_encode($obj), true);

        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return array_values($ret);
    
    }
}