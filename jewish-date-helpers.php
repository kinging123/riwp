<?php
function riwp_date_to_jewish( $date, $mods = null ) {
	$date_parts = explode( '-', $date );
	$jd = gregoriantojd( $date_parts[1], $date_parts[0], $date_parts[2] );
	$jewish = jdtojewish( $jd, true, $mods );
	$hebrew_date = iconv( 'WINDOWS-1255', 'UTF-8', $jewish );
	return $hebrew_date;
}

function riwp_get_anniv_day( $date ) {
	$hebrew_date = riwp_date_to_jewish( $date );
	$date_parts = explode( ' ', $hebrew_date );
	return $date_parts[0] . ' ' . $date_parts[1];
}


global $riwp_anniv_list;
function riwp_generate_global_anniv_list() {
	global $riwp_anniv_list;
	$riwp_anniv_list = array();
	$days = array( 'א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ז', 'ח', 'ט', 'י', 'יא', 'יב', 'יג', 'יד', 'טו', 'טז', 'יז', 'יח', 'יט', 'כ', 'כא', 'כב', 'כג', 'כד', 'כה', 'כו', 'כז', 'כח', 'כט', 'ל' );
	$months = array( 'תשרי', 'חשוון', 'כסלו', 'טבת', 'שבט', 'אדר', 'ניסן', 'אייר', 'סיון', 'תמוז', 'אב', 'אלול' );
	foreach ( $months as $month ) {
		foreach ( $days as $day ) {
			$riwp_anniv_list[] = $day . ' ' . $month;
		}
	}
}
riwp_generate_global_anniv_list();
