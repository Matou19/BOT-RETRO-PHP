<?php 
/*
 * By Burak (skype: burak.karamahmut)
 */
function encodeLength($value)
        {
            $length = 2;
            $stack = "";
            for ($x = 1; $x <= $length; $x++)
            {
                $offset = 6 * ($length - $x);
                $val = (64 + ($value >> $offset & 0x3f));
                $stack .= chr($val);
            }
            return $stack;
        }
		function decodeLength( $s ){
                if(is_string($s)){
                                $val = str_split($s);
                                $intTot = 0;
                                $y = 0;
                                for($x = (count($val) -1); $x >= 0; $x--){
                                        $intTmp = ord($val[$x]) & 0x3F;
                                        if($y > 0){
                                                $intTmp = ($intTmp*pow(64, $y));
                                        }
                                        $intTot+= $intTmp;
                                        $y++;
                                }
                                return $intTot; return 0;
                }else{
                        return 0;
                }
        }
		function encodeInt($i){
                $wf = array();
                $pos = 0;
                $startPos = 0;
                $bytes = 1;
                $negativeMask = $i>=0?0:4;
                $i = abs($i);
                $wf[$pos++] = 64 + ($i & 3);
                for ($i >>= 2; $i != 0; $i >>= 6){
                        $bytes++;
                        $wf[$pos++] = 64 + ($i & 0x3f);
                }
                $wf[$startPos] = $wf[$startPos] | $bytes << 3 | $negativeMask;
                $str = "";
                foreach($wf as $tmp)
                        $str .= chr($tmp);
                return str_replace("\0","",$str);
        }
		function decodeInt($raw)
        {
				$raw = str_split($raw);
				
                $pos = 0;
                $v = 0;
                $totalBytes = $raw[$pos] >> 3 & 7;
                $v = $raw[$pos] & 3;
                $pos++;
                $shiftAmount = 2;
                for ($b = 1; $b < $totalBytes; $b++)
                {
                    $v |= ($raw[$pos] & 0x3f) << $shiftAmount;
                    $shiftAmount = 2 + 6 * $b;
                    $pos++;
                }

                if (($raw[$pos] & 4) == 4)
                    $v *= -1;

                return $v;
        }