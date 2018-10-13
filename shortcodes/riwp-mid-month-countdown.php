<?php


if ( ! function_exists( 'is_jewish_leap_year' ) ) {
	function is_jewish_leap_year( $year ) {
		if ( $year % 19 == 0 || $year % 19 == 3 || $year % 19 == 6 ||
		  $year % 19 == 8 || $year % 19 == 11 || $year % 19 == 14 ||
		  $year % 19 == 17 ) {
			return true;
		} else {
			return false;
		}
	}
}

$today = jdtojewish( gregoriantojd( date( 'm' ), date( 'd' ), date( 'Y' ) ), false );
$today_parts = explode( '/', $today );

$jewish_month = $today_parts[0];
$jewish_year = $today_parts[2];

$jewish_next_month = $jewish_month + 1;

if ( ! is_jewish_leap_year( $jewish_year ) && 6 === $jewish_next_month ) {
	$jewish_next_month = 7;
}

if ( $jewish_next_month > 13 ) {
	$jewish_year++;
	$jewish_next_month = 1;
}

$jd_first_day = jewishtojd( $jewish_next_month, 1, $jewish_year );

$gd_date = jdtogregorian( $jd_first_day );
$gd_date = explode( '/', $gd_date );
$gd_date = $gd_date[1] . '-' . $gd_date[0] . '-' . $gd_date[2];
$weekday = date( 'w', strtotime( $gd_date ) );

if ( 6 === $weekday ) { // If on Saturday,
	$jd_first_day++; // The date is on Sunday instead
}

$jd_today = unixtojd();

echo $jd_first_day - $jd_today;
