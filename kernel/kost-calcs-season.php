<?php
/**
 * Created by PhpStorm
 * User: Andreas Express
 * Date: 9/8/17
 * Time: 4:14 PM
 */

function call_user_kerdismena_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = call_user_kerdismena(null, $monlink);
		$n[$monlink] = number_format($n[$monlink], 0);

		//go one step further..
		$monlink = monlink_step($monlink);
	}

	return array_sum($n);
}

function call_user_success_rate_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	while ($monlink <= $monlink_end) {

		$n[$monlink] = call_user_kerdismena(null, $monlink);
		$m[$monlink] = call_user_records(null, $monlink);
		$monlink = monlink_step($monlink);
	}

	$sn = array_sum($n);
	$sm = array_sum($m);
	if ($sm != 0) {

		$number = ($sn / $sm) * 100;
		return number_format($number);
	} else {

		return 0;
	}
}

function call_user_records_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = call_user_records(null, $monlink);
		$n[$monlink] = number_format($n[$monlink], 0);
		$monlink = monlink_step($monlink);
	}

	return array_sum($n);
}

function count_user_xamena_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = count_user_xamena(null, $monlink);
		$n[$monlink] = number_format($n[$monlink], 0);
		$monlink = monlink_step($monlink);
	}

	return array_sum($n);
}

function call_user_average_odds_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = 0;
	$i = 0;
	while ($monlink <= $monlink_end) {

		$n = call_user_total_odds(null, $monlink) + $n;
		$i = call_user_records(null, $monlink) + $i;
		$monlink = monlink_step($monlink);
	}

	if ($i == 0) {

		return 0;
	} else {

		return number_format($n / $i, 2);
	}
}

function count_user_stake_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = count_user_stake(null, $monlink);
		$monlink = monlink_step($monlink);
	}

	return array_sum($n);
}

function count_user_yield_by_season($monlink_start, $monlink_end)
{
	$profit = count_user_profit_by_season($monlink_start, $monlink_end);
	$stake = count_user_stake_by_season($monlink_start, $monlink_end);
	if ($stake != 0) {
		return number_format($profit / $stake * 100, 2);
	} else {
		return 0;
	}
}

//function count_user_yield_by_season($monlink_start, $monlink_end)
//{

//	$monlink = $monlink_start;
//	$n = array();
//	while ($monlink <= $monlink_end) {

//		$n[$monlink] = count_user_yield(null, $monlink);
//		$monlink = monlink_step($monlink);
//	}

//	return array_sum($n);
//}

function count_user_draws_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = count_user_draws(null, $monlink);
		$n[$monlink] = number_format($n[$monlink], 0);
		$monlink = monlink_step($monlink);
	}

	return array_sum($n);
}

function count_user_profit_by_season($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$n = array();
	while ($monlink <= $monlink_end) {

		$n[$monlink] = count_user_profit(null, $monlink);
		$n[$monlink] = str_replace("+", '', $n[$monlink]);
		$monlink = monlink_step($monlink);
	}

	$s = array_sum($n);
	if ($s >= 0) {

		$p = "+";
	} else {

		$p = null;
	}
	return $p . array_sum($n);
}

?>