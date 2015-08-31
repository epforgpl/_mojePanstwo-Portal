<?

function smarty_modifier_truncate($string, $length = 80, $etc = '...',
                                  $break_words = false, $middle = false)
{
    if ($length == 0)
        return '';

    if (strlen($string) > $length) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
        }
        if(!$middle) {
            return substr($string, 0, $length) . $etc;
        } else {
            return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
        }
    } else {
        return $string;
    }
}

function _ucfirst( $str ) {

	if ( ! $str ) {
		return '';
	}

	$words = explode( ' ', trim( $str ) );
	foreach ( $words as &$w ) {

		$rest = strtolower( substr( $w, 1 ) );
		$rest = str_replace( array(
			'Ę',
			'Ó',
			'Ą',
			'Ś',
			'Ł',
			'Ż',
			'Ź',
			'Ć',
			'Ń',
		), array(
			'ę',
			'ó',
			'ą',
			'ś',
			'ł',
			'ż',
			'ź',
			'ć',
			'ń',
		), $rest );

		$w = strtoupper( $w[0] ) . $rest;

	}

	return str_replace( array(
		' Z ',
	), array(
		' z ',
	), implode( ' ', $words ) );

}

function pl_wiek( $data ) {
	$birthDate = explode( "-", substr( $data, 0, 10 ) );
	$age       = ( date( "md", date( "U", mktime( 0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0] ) ) ) > date( "md" ) ? @( ( date( "Y" ) - $birthDate[0] ) - 1 ) : @( date( "Y" ) - $birthDate[0] ) );

	return $age;
}

function pl_dopelniacz( $count = 0, $formA = '', $formB = '', $formC = '', $options = array() ) {
	if ( $count == 0 ) {
		return '';
	} elseif ( $count == 1 ) {
		$r = $formA;
	} elseif ( $count < 5 ) {
		$r = $formB;
	} elseif ( $count < 22 ) {
		$r = $formC;
	} else {
		$d = $count % 10;
		if ( $d < 2 ) {
			$r = $formC;
		} elseif ( $d < 5 ) {
			$r = $formB;
		} else {
			$r = $formC;
		}
	}


	$options['numberTag'] = isset( $options['numberTag'] ) ? $options['numberTag'] : 'strong';

	if ( $options['numberTag'] ) {
		$count = '<' . $options['numberTag'] . '>' . _number( $count ) . '</' . $options['numberTag'] . '>';
	}

	return $count . '&nbsp;' . $r;
}

if ( ! function_exists( 'array_column' ) ) {
	function array_column( $array, $column_key, $index_key = null ) {
		$output = array();
		if ( is_array( $array ) && ! empty( $array ) ) {
			foreach ( $array as $record ) {
				if ( array_key_exists( $column_key, $record ) ) {
					if ( $index_key ) {
						$output[ $record[ $index_key ] ] = $record[ $column_key ];
					} else {
						$output[] = $record[ $column_key ];
					}
				}
			}
		}

		return $output;
	}
}

function dataSlownie( $data, $options = array() ) {
	$_data = $data;
	$_parts = explode(' ', $data);

	if ( strpos( $_parts[0], '/' ) ) {
		$parts = explode( '/', $_parts[0] );
		$data  = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
	}

	$timestamp = strtotime( $data );
	if ( ! $timestamp ) {
		return false;
	}

	$data = date( 'Y-m-d', $timestamp );

	if ( $data == date( 'Y-m-d', time() ) ) // TODAY
	{

		$str = 'dzisiaj';

	} else {


		$___vars = array(
			'miesiace' => array(
				'celownik' => array(
					1  => 'stycznia',
					2  => 'lutego',
					3  => 'marca',
					4  => 'kwietnia',
					5  => 'maja',
					6  => 'czerwca',
					7  => 'lipca',
					8  => 'sierpnia',
					9  => 'września',
					10 => 'października',
					11 => 'listopada',
					12 => 'grudnia',
				),
			),
		);

		$parts = explode( '-', substr( $data, 0, 10 ) );
		if ( count( $parts ) != 3 ) {
			return $data;
		}

		$dzien   = (int) $parts[2];
		$miesiac = (int) $parts[1];
		$rok     = (int) $parts[0];


        $str = $dzien . ' ' . $___vars['miesiace']['celownik'][$miesiac] . ' ' . $rok . '&nbsp;r.';

	}

	if( isset($_parts[1]) )
		$str .= ' ' . $_parts[1];

	/*
	$time_str = @substr($_data, 11, 5);
	if( $time_str )
		$str .= ' ' . $time_str;
	*/


	$output = '<span class="_ds"';

	if( isset($options['itemprop']) && $options['itemprop'] )
		$output .= ' itemprop="' . $options['itemprop'] . '"';

	$output .= ' datetime="' . strip_tags( $data ) . '">' . $str . '</span>';

	return $output;
}


if ( ! function_exists( 'startsWith' ) ) {
	function startsWith( $haystack, $needle ) {
		return $needle === "" || stripos( $haystack, $needle ) === 0;
	}
}

if ( ! function_exists( 'endsWith' ) ) {
	function endsWith( $haystack, $needle ) {
		return $needle === "" || strtoupper( substr( $haystack, - strlen( $needle ) ) ) === strtoupper( $needle );
	}
}

#    Output easy-to-read numbers
#    by james at bandit.co.nz

function _currency( $value ) {
	$parts = explode( ',', number_format( $value, 2, ',', ' ' ) );

	return '<span class="_currency">' . $parts[0] . '<span class="_subcurrency">,' . $parts[1] . ' PLN</span></span>';
}

function _number( $value ) {
	return '<span class="_number">' . number_format( $value, $decimals = 0, $dec_point = '', $thousands_sep = ' ' ) . '</span>';
}

function number_format_h( $n, $decimals = 0, $dec_point = '.', $thousands_sep = ' ' ) {
	// first strip any formatting;
	$n = ( 0 + str_replace( ",", "", $n ) );

	// is this a number?
	if ( ! is_numeric( $n ) ) {
		return false;
	}

	$_n = abs( $n );

	// now filter it;
	if ( $_n > 1000000000000000 ) {
		return round( ( $n / 1000000000000000 ), 1 ) . '&nbsp;bld';
	} else if ( $_n > 1000000000000 ) {
		return round( ( $n / 1000000000000 ), 1 ) . '&nbsp;bln';
	} else if ( $_n > 1000000000 ) {
		return round( ( $n / 1000000000 ), 1 ) . '&nbsp;mld';
	} else if ( $_n > 1000000 ) {
		return round( ( $n / 1000000 ), 1 ) . '&nbsp;mln';
	} else if ( $_n > 1000 ) {
		return round( ( $n / 1000 ), 1 ) . '&nbsp;tys.';
	}

	return number_format( $n, $decimals, $dec_point, $thousands_sep );
}

function __currency( $input, $inputFormat = 'k' ) {

	if ( ! $input ) {
		return '';
	}

	return number_format( $input / 1000, $decimals = 1, $dec_point = '.', $thousands_sep = '&nbsp;' );

}

function atomTime( $inp = false ) {
	if ( $inp === false ) {
		return date( 'Y-m-d\TH:i:s\Z', time() );
	} else {
		return date( 'Y-m-d\TH:i:s\Z', strtotime( $inp ) );
	}
}

function closetags( $html ) {
#put all opened tags into an array
	preg_match_all( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
	$openedtags = $result[1];

#put all closed tags into an array
	preg_match_all( "#</([a-z]+)>#iU", $html, $result );
	$closedtags = $result[1];
	$len_opened = count( $openedtags );
# all tags are closed
	if ( count( $closedtags ) == $len_opened ) {
		return $html;
	}
	$openedtags = array_reverse( $openedtags );
# close tags
	for ( $i = 0; $i < $len_opened; $i ++ ) {
		if ( ! in_array( $openedtags[ $i ], $closedtags ) ) {
			$html .= "</" . $openedtags[ $i ] . ">";
		} else {
			unset ( $closedtags[ array_search( $openedtags[ $i ], $closedtags ) ] );
		}
	}

	return $html;
}

function human_filesize($bytes, $dec = 2)
{
    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
}

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
}

function es_range_number($value) {
    $parts = explode('TO', $value);
    $from = filter_var($parts[0], FILTER_SANITIZE_NUMBER_INT);
    $to = filter_var($parts[1], FILTER_SANITIZE_NUMBER_INT);

    if($from == 1)
        $from = '';

    if($to == '')
        return '> ' . number_format_h($from);
    elseif($from == '')
        return '< ' . number_format_h($to);
    else
        return number_format_h($from) . ' - ' . number_format_h($to);
}

function __months($lang = 'pl') {
	return array(
		'Styczeń',
		'Luty',
		'Marzec',
		'Kwiecień',
		'Maj',
		'Czerwiec',
		'Lipiec',
		'Sierpień',
		'Wrzesień',
		'Październik',
		'Listopad',
		'Grudzień',
	);
}
