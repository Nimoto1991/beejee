<?php
/** Adminer - Compact database management
 * @link https://www.adminer.org/
 * @author Jakub Vrana, https://www.vrana.cz/
 * @copyright 2007 Jakub Vrana
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 * @version 4.7.7
 */
error_reporting(6135);
$Zc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($Zc || ini_get("filter.default_flags")) {
	foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $X) {
		$Li = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
		if ($Li) $$X = $Li;
	}
}
if (function_exists("mb_internal_encoding")) mb_internal_encoding("8bit");
function
connection() {
	global $h;
	return $h;
}

function
adminer() {
	global $b;
	return $b;
}

function
version() {
	global $ia;
	return $ia;
}

function
idf_unescape($u) {
	$se = substr($u, -1);
	return
		str_replace($se . $se, $se, substr($u, 1, -1));
}

function
escape_string($X) {
	return
		substr(q($X), 1, -1);
}

function
number($X) {
	return
		preg_replace('~[^0-9]+~', '', $X);
}

function
number_type() {
	return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}

function
remove_slashes($vg, $Zc = false) {
	if (get_magic_quotes_gpc()) {
		while (list($y, $X) = each($vg)) {
			foreach ($X
					 as $he => $W) {
				unset($vg[$y][$he]);
				if (is_array($W)) {
					$vg[$y][stripslashes($he)] = $W;
					$vg[] =& $vg[$y][stripslashes($he)];
				} else$vg[$y][stripslashes($he)] = ($Zc ? $W : stripslashes($W));
			}
		}
	}
}

function
bracket_escape($u, $Pa = false) {
	static $xi = array(':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4');
	return
		strtr($u, ($Pa ? array_flip($xi) : $xi));
}

function
min_version($dj, $Ge = "", $i = null) {
	global $h;
	if (!$i) $i = $h;
	$qh = $i->server_info;
	if ($Ge && preg_match('~([\d.]+)-MariaDB~', $qh, $A)) {
		$qh = $A[1];
		$dj = $Ge;
	}
	return (version_compare($qh, $dj) >= 0);
}

function
charset($h) {
	return (min_version("5.5.3", 0, $h) ? "utf8mb4" : "utf8");
}

function
script($Ah, $wi = "\n") {
	return "<script" . nonce() . ">$Ah</script>$wi";
}

function
script_src($Qi) {
	return "<script src='" . h($Qi) . "'" . nonce() . "></script>\n";
}

function
nonce() {
	return ' nonce="' . get_nonce() . '"';
}

function
target_blank() {
	return ' target="_blank" rel="noreferrer noopener"';
}

function
h($P) {
	return
		str_replace("\0", "&#0;", htmlspecialchars($P, ENT_QUOTES, 'utf-8'));
}

function
nl_br($P) {
	return
		str_replace("\n", "<br>", $P);
}

function
checkbox($B, $Y, $gb, $oe = "", $xf = "", $lb = "", $pe = "") {
	$H = "<input type='checkbox' name='$B' value='" . h($Y) . "'" . ($gb ? " checked" : "") . ($pe ? " aria-labelledby='$pe'" : "") . ">" . ($xf ? script("qsl('input').onclick = function () { $xf };", "") : "");
	return ($oe != "" || $lb ? "<label" . ($lb ? " class='$lb'" : "") . ">$H" . h($oe) . "</label>" : $H);
}

function
optionlist($Cf, $kh = null, $Vi = false) {
	$H = "";
	foreach ($Cf
			 as $he => $W) {
		$Df = array($he => $W);
		if (is_array($W)) {
			$H .= '<optgroup label="' . h($he) . '">';
			$Df = $W;
		}
		foreach ($Df
				 as $y => $X) $H .= '<option' . ($Vi || is_string($y) ? ' value="' . h($y) . '"' : '') . (($Vi || is_string($y) ? (string)$y : $X) === $kh ? ' selected' : '') . '>' . h($X);
		if (is_array($W)) $H .= '</optgroup>';
	}
	return $H;
}

function
html_select($B, $Cf, $Y = "", $wf = true, $pe = "") {
	if ($wf) return "<select name='" . h($B) . "'" . ($pe ? " aria-labelledby='$pe'" : "") . ">" . optionlist($Cf, $Y) . "</select>" . (is_string($wf) ? script("qsl('select').onchange = function () { $wf };", "") : "");
	$H = "";
	foreach ($Cf
			 as $y => $X) $H .= "<label><input type='radio' name='" . h($B) . "' value='" . h($y) . "'" . ($y == $Y ? " checked" : "") . ">" . h($X) . "</label>";
	return $H;
}

function
select_input($Ka, $Cf, $Y = "", $wf = "", $hg = "") {
	$bi = ($Cf ? "select" : "input");
	return "<$bi$Ka" . ($Cf ? "><option value=''>$hg" . optionlist($Cf, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$hg'>") . ($wf ? script("qsl('$bi').onchange = $wf;", "") : "");
}

function
confirm($Qe = "", $lh = "qsl('input')") {
	return
		script("$lh.onclick = function () { return confirm('" . ($Qe ? js_escape($Qe) : lang(0)) . "'); };", "");
}

function
print_fieldset($t, $xe, $gj = false) {
	echo "<fieldset><legend>", "<a href='#fieldset-$t'>$xe</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$t');", ""), "</legend>", "<div id='fieldset-$t'" . ($gj ? "" : " class='hidden'") . ">\n";
}

function
bold($Xa, $lb = "") {
	return ($Xa ? " class='active $lb'" : ($lb ? " class='$lb'" : ""));
}

function
odd($H = ' class="odd"') {
	static $s = 0;
	if (!$H) $s = -1;
	return ($s++ % 2 ? $H : '');
}

function
js_escape($P) {
	return
		addcslashes($P, "\r\n'\\/");
}

function
json_row($y, $X = null) {
	static $ad = true;
	if ($ad) echo "{";
	if ($y != "") {
		echo ($ad ? "" : ",") . "\n\t\"" . addcslashes($y, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
		$ad = false;
	} else {
		echo "\n}\n";
		$ad = true;
	}
}

function
ini_bool($Ud) {
	$X = ini_get($Ud);
	return (preg_match('~^(on|true|yes)$~i', $X) || (int)$X);
}

function
sid() {
	static $H;
	if ($H === null) $H = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
	return $H;
}

function
set_password($cj, $M, $V, $E) {
	$_SESSION["pwds"][$cj][$M][$V] = ($_COOKIE["adminer_key"] && is_string($E) ? array(encrypt_string($E, $_COOKIE["adminer_key"])) : $E);
}

function
get_password() {
	$H = get_session("pwds");
	if (is_array($H)) $H = ($_COOKIE["adminer_key"] ? decrypt_string($H[0], $_COOKIE["adminer_key"]) : false);
	return $H;
}

function
q($P) {
	global $h;
	return $h->quote($P);
}

function
get_vals($F, $e = 0) {
	global $h;
	$H = array();
	$G = $h->query($F);
	if (is_object($G)) {
		while ($I = $G->fetch_row()) $H[] = $I[$e];
	}
	return $H;
}

function
get_key_vals($F, $i = null, $th = true) {
	global $h;
	if (!is_object($i)) $i = $h;
	$H = array();
	$G = $i->query($F);
	if (is_object($G)) {
		while ($I = $G->fetch_row()) {
			if ($th) $H[$I[0]] = $I[1]; else$H[] = $I[0];
		}
	}
	return $H;
}

function
get_rows($F, $i = null, $n = "<p class='error'>") {
	global $h;
	$zb = (is_object($i) ? $i : $h);
	$H = array();
	$G = $zb->query($F);
	if (is_object($G)) {
		while ($I = $G->fetch_assoc()) $H[] = $I;
	} elseif (!$G && !is_object($i) && $n && defined("PAGE_HEADER")) echo $n . error() . "\n";
	return $H;
}

function
unique_array($I, $w) {
	foreach ($w
			 as $v) {
		if (preg_match("~PRIMARY|UNIQUE~", $v["type"])) {
			$H = array();
			foreach ($v["columns"] as $y) {
				if (!isset($I[$y])) continue
				2;
				$H[$y] = $I[$y];
			}
			return $H;
		}
	}
}

function
escape_key($y) {
	if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $y, $A)) return $A[1] . idf_escape(idf_unescape($A[2])) . $A[3];
	return
		idf_escape($y);
}

function
where($Z, $p = array()) {
	global $h, $x;
	$H = array();
	foreach ((array)$Z["where"] as $y => $X) {
		$y = bracket_escape($y, 1);
		$e = escape_key($y);
		$H[] = $e . ($x == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($x == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($p[$y], q($X))));
		if ($x == "sql" && preg_match('~char|text~', $p[$y]["type"]) && preg_match("~[^ -@]~", $X)) $H[] = "$e = " . q($X) . " COLLATE " . charset($h) . "_bin";
	}
	foreach ((array)$Z["null"] as $y) $H[] = escape_key($y) . " IS NULL";
	return
		implode(" AND ", $H);
}

function
where_check($X, $p = array()) {
	parse_str($X, $eb);
	remove_slashes(array(&$eb));
	return
		where($eb, $p);
}

function
where_link($s, $e, $Y, $zf = "=") {
	return "&where%5B$s%5D%5Bcol%5D=" . urlencode($e) . "&where%5B$s%5D%5Bop%5D=" . urlencode(($Y !== null ? $zf : "IS NULL")) . "&where%5B$s%5D%5Bval%5D=" . urlencode($Y);
}

function
convert_fields($f, $p, $K = array()) {
	$H = "";
	foreach ($f
			 as $y => $X) {
		if ($K && !in_array(idf_escape($y), $K)) continue;
		$Ha = convert_field($p[$y]);
		if ($Ha) $H .= ", $Ha AS " . idf_escape($y);
	}
	return $H;
}

function
cookie($B, $Y, $_e = 2592000) {
	global $ba;
	return
		header("Set-Cookie: $B=" . urlencode($Y) . ($_e ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $_e) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}

function
restart_session() {
	if (!ini_bool("session.use_cookies")) session_start();
}

function
stop_session($fd = false) {
	$Ui = ini_bool("session.use_cookies");
	if (!$Ui || $fd) {
		session_write_close();
		if ($Ui && @ini_set("session.use_cookies", false) === false) session_start();
	}
}

function&get_session($y) {
	return $_SESSION[$y][DRIVER][SERVER][$_GET["username"]];
}

function
set_session($y, $X) {
	$_SESSION[$y][DRIVER][SERVER][$_GET["username"]] = $X;
}

function
auth_url($cj, $M, $V, $l = null) {
	global $ic;
	preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($ic)) . "|username|" . ($l !== null ? "db|" : "") . session_name()), $A);
	return "$A[1]?" . (sid() ? SID . "&" : "") . ($cj != "server" || $M != "" ? urlencode($cj) . "=" . urlencode($M) . "&" : "") . "username=" . urlencode($V) . ($l != "" ? "&db=" . urlencode($l) : "") . ($A[2] ? "&$A[2]" : "");
}

function
is_ajax() {
	return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

function
redirect($Be, $Qe = null) {
	if ($Qe !== null) {
		restart_session();
		$_SESSION["messages"][preg_replace('~^[^?]*~', '', ($Be !== null ? $Be : $_SERVER["REQUEST_URI"]))][] = $Qe;
	}
	if ($Be !== null) {
		if ($Be == "") $Be = ".";
		header("Location: $Be");
		exit;
	}
}

function
query_redirect($F, $Be, $Qe, $Gg = true, $Gc = true, $Rc = false, $ji = "") {
	global $h, $n, $b;
	if ($Gc) {
		$Ih = microtime(true);
		$Rc = !$h->query($F);
		$ji = format_time($Ih);
	}
	$Dh = "";
	if ($F) $Dh = $b->messageQuery($F, $ji, $Rc);
	if ($Rc) {
		$n = error() . $Dh . script("messagesPrint();");
		return
			false;
	}
	if ($Gg) redirect($Be, $Qe . $Dh);
	return
		true;
}

function
queries($F) {
	global $h;
	static $_g = array();
	static $Ih;
	if (!$Ih) $Ih = microtime(true);
	if ($F === null) return
		array(implode("\n", $_g), format_time($Ih));
	$_g[] = (preg_match('~;$~', $F) ? "DELIMITER ;;\n$F;\nDELIMITER " : $F) . ";";
	return $h->query($F);
}

function
apply_queries($F, $S, $Cc = 'table') {
	foreach ($S
			 as $Q) {
		if (!queries("$F " . $Cc($Q))) return
			false;
	}
	return
		true;
}

function
queries_redirect($Be, $Qe, $Gg) {
	list($_g, $ji) = queries(null);
	return
		query_redirect($_g, $Be, $Qe, $Gg, false, !$Gg, $ji);
}

function
format_time($Ih) {
	return
		lang(1, max(0, microtime(true) - $Ih));
}

function
relative_uri() {
	return
		preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]);
}

function
remove_from_uri($Sf = "") {
	return
		substr(preg_replace("~(?<=[?&])($Sf" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
}

function
pagination($D, $Nb) {
	return " " . ($D == $Nb ? $D + 1 : '<a href="' . h(remove_from_uri("page") . ($D ? "&page=$D" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($D + 1) . "</a>");
}

function
get_file($y, $Vb = false) {
	$Xc = $_FILES[$y];
	if (!$Xc) return
		null;
	foreach ($Xc
			 as $y => $X) $Xc[$y] = (array)$X;
	$H = '';
	foreach ($Xc["error"] as $y => $n) {
		if ($n) return $n;
		$B = $Xc["name"][$y];
		$ri = $Xc["tmp_name"][$y];
		$Bb = file_get_contents($Vb && preg_match('~\.gz$~', $B) ? "compress.zlib://$ri" : $ri);
		if ($Vb) {
			$Ih = substr($Bb, 0, 3);
			if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $Ih, $Mg)) $Bb = iconv("utf-16", "utf-8", $Bb); elseif ($Ih == "\xEF\xBB\xBF") $Bb = substr($Bb, 3);
			$H .= $Bb . "\n\n";
		} else$H .= $Bb;
	}
	return $H;
}

function
upload_error($n) {
	$Ne = ($n == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
	return ($n ? lang(2) . ($Ne ? " " . lang(3, $Ne) : "") : lang(4));
}

function
repeat_pattern($fg, $ye) {
	return
		str_repeat("$fg{0,65535}", $ye / 65535) . "$fg{0," . ($ye % 65535) . "}";
}

function
is_utf8($X) {
	return (preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}

function
shorten_utf8($P, $ye = 80, $Ph = "") {
	if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $ye) . ")($)?)u", $P, $A)) preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $ye) . ")($)?)", $P, $A);
	return
		h($A[1]) . $Ph . (isset($A[2]) ? "" : "<i>…</i>");
}

function
format_number($X) {
	return
		strtr(number_format($X, 0, ".", lang(5)), preg_split('~~u', lang(6), -1, PREG_SPLIT_NO_EMPTY));
}

function
friendly_url($X) {
	return
		preg_replace('~[^a-z0-9_]~i', '-', $X);
}

function
hidden_fields($vg, $Jd = array()) {
	$H = false;
	while (list($y, $X) = each($vg)) {
		if (!in_array($y, $Jd)) {
			if (is_array($X)) {
				foreach ($X
						 as $he => $W) $vg[$y . "[$he]"] = $W;
			} else {
				$H = true;
				echo '<input type="hidden" name="' . h($y) . '" value="' . h($X) . '">';
			}
		}
	}
	return $H;
}

function
hidden_fields_get() {
	echo(sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''), (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""), '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

function
table_status1($Q, $Sc = false) {
	$H = table_status($Q, $Sc);
	return ($H ? $H : array("Name" => $Q));
}

function
column_foreign_keys($Q) {
	global $b;
	$H = array();
	foreach ($b->foreignKeys($Q) as $q) {
		foreach ($q["source"] as $X) $H[$X][] = $q;
	}
	return $H;
}

function
enum_input($T, $Ka, $o, $Y, $xc = null) {
	global $b;
	preg_match_all("~'((?:[^']|'')*)'~", $o["length"], $Ie);
	$H = ($xc !== null ? "<label><input type='$T'$Ka value='$xc'" . ((is_array($Y) ? in_array($xc, $Y) : $Y === 0) ? " checked" : "") . "><i>" . lang(7) . "</i></label>" : "");
	foreach ($Ie[1] as $s => $X) {
		$X = stripcslashes(str_replace("''", "'", $X));
		$gb = (is_int($Y) ? $Y == $s + 1 : (is_array($Y) ? in_array($s + 1, $Y) : $Y === $X));
		$H .= " <label><input type='$T'$Ka value='" . ($s + 1) . "'" . ($gb ? ' checked' : '') . '>' . h($b->editVal($X, $o)) . '</label>';
	}
	return $H;
}

function
input($o, $Y, $r) {
	global $U, $b, $x;
	$B = h(bracket_escape($o["field"]));
	echo "<td class='function'>";
	if (is_array($Y) && !$r) {
		$Fa = array($Y);
		if (version_compare(PHP_VERSION, 5.4) >= 0) $Fa[] = JSON_PRETTY_PRINT;
		$Y = call_user_func_array('json_encode', $Fa);
		$r = "json";
	}
	$Qg = ($x == "mssql" && $o["auto_increment"]);
	if ($Qg && !$_POST["save"]) $r = null;
	$od = (isset($_GET["select"]) || $Qg ? array("orig" => lang(8)) : array()) + $b->editFunctions($o);
	$Ka = " name='fields[$B]'";
	if ($o["type"] == "enum") echo
		h($od[""]) . "<td>" . $b->editInput($_GET["edit"], $o, $Ka, $Y); else {
		$yd = (in_array($r, $od) || isset($od[$r]));
		echo (count($od) > 1 ? "<select name='function[$B]'>" . optionlist($od, $r === null || $yd ? $r : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($od))) . '<td>';
		$Wd = $b->editInput($_GET["edit"], $o, $Ka, $Y);
		if ($Wd != "") echo $Wd; elseif (preg_match('~bool~', $o["type"])) echo "<input type='hidden'$Ka value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$Ka value='1'>";
        elseif ($o["type"] == "set") {
			preg_match_all("~'((?:[^']|'')*)'~", $o["length"], $Ie);
			foreach ($Ie[1] as $s => $X) {
				$X = stripcslashes(str_replace("''", "'", $X));
				$gb = (is_int($Y) ? ($Y >> $s) & 1 : in_array($X, explode(",", $Y), true));
				echo " <label><input type='checkbox' name='fields[$B][$s]' value='" . (1 << $s) . "'" . ($gb ? ' checked' : '') . ">" . h($b->editVal($X, $o)) . '</label>';
			}
		} elseif (preg_match('~blob|bytea|raw|file~', $o["type"]) && ini_bool("file_uploads")) echo "<input type='file' name='fields-$B'>";
        elseif (($hi = preg_match('~text|lob|memo~i', $o["type"])) || preg_match("~\n~", $Y)) {
			if ($hi && $x != "sqlite") $Ka .= " cols='50' rows='12'"; else {
				$J = min(12, substr_count($Y, "\n") + 1);
				$Ka .= " cols='30' rows='$J'" . ($J == 1 ? " style='height: 1.2em;'" : "");
			}
			echo "<textarea$Ka>" . h($Y) . '</textarea>';
		} elseif ($r == "json" || preg_match('~^jsonb?$~', $o["type"])) echo "<textarea$Ka cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
		else {
			$Pe = (!preg_match('~int~', $o["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $o["length"], $A) ? ((preg_match("~binary~", $o["type"]) ? 2 : 1) * $A[1] + ($A[3] ? 1 : 0) + ($A[2] && !$o["unsigned"] ? 1 : 0)) : ($U[$o["type"]] ? $U[$o["type"]] + ($o["unsigned"] ? 0 : 1) : 0));
			if ($x == 'sql' && min_version(5.6) && preg_match('~time~', $o["type"])) $Pe += 7;
			echo "<input" . ((!$yd || $r === "") && preg_match('~(?<!o)int(?!er)~', $o["type"]) && !preg_match('~\[\]~', $o["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Pe ? " data-maxlength='$Pe'" : "") . (preg_match('~char|binary~', $o["type"]) && $Pe > 20 ? " size='40'" : "") . "$Ka>";
		}
		echo $b->editHint($_GET["edit"], $o, $Y);
		$ad = 0;
		foreach ($od
				 as $y => $X) {
			if ($y === "" || !$X) break;
			$ad++;
		}
		if ($ad) echo
		script("mixin(qsl('td'), {onchange: partial(skipOriginal, $ad), oninput: function () { this.onchange(); }});");
	}
}

function
process_input($o) {
	global $b, $m;
	$u = bracket_escape($o["field"]);
	$r = $_POST["function"][$u];
	$Y = $_POST["fields"][$u];
	if ($o["type"] == "enum") {
		if ($Y == -1) return
			false;
		if ($Y == "") return "NULL";
		return +$Y;
	}
	if ($o["auto_increment"] && $Y == "") return
		null;
	if ($r == "orig") return (preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? idf_escape($o["field"]) : false);
	if ($r == "NULL") return "NULL";
	if ($o["type"] == "set") return
		array_sum((array)$Y);
	if ($r == "json") {
		$r = "";
		$Y = json_decode($Y, true);
		if (!is_array($Y)) return
			false;
		return $Y;
	}
	if (preg_match('~blob|bytea|raw|file~', $o["type"]) && ini_bool("file_uploads")) {
		$Xc = get_file("fields-$u");
		if (!is_string($Xc)) return
			false;
		return $m->quoteBinary($Xc);
	}
	return $b->processInput($o, $Y, $r);
}

function
fields_from_edit() {
	global $m;
	$H = array();
	foreach ((array)$_POST["field_keys"] as $y => $X) {
		if ($X != "") {
			$X = bracket_escape($X);
			$_POST["function"][$X] = $_POST["field_funs"][$y];
			$_POST["fields"][$X] = $_POST["field_vals"][$y];
		}
	}
	foreach ((array)$_POST["fields"] as $y => $X) {
		$B = bracket_escape($y, 1);
		$H[$B] = array("field" => $B, "privileges" => array("insert" => 1, "update" => 1), "null" => 1, "auto_increment" => ($y == $m->primary),);
	}
	return $H;
}

function
search_tables() {
	global $b, $h;
	$_GET["where"][0]["val"] = $_POST["query"];
	$nh = "<ul>\n";
	foreach (table_status('', true) as $Q => $R) {
		$B = $b->tableName($R);
		if (isset($R["Engine"]) && $B != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
			$G = $h->query("SELECT" . limit("1 FROM " . table($Q), " WHERE " . implode(" AND ", $b->selectSearchProcess(fields($Q), array())), 1));
			if (!$G || $G->fetch_row()) {
				$rg = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$B</a>";
				echo "$nh<li>" . ($G ? $rg : "<p class='error'>$rg: " . error()) . "\n";
				$nh = "";
			}
		}
	}
	echo ($nh ? "<p class='message'>" . lang(9) : "</ul>") . "\n";
}

function
dump_headers($Gd, $Ze = false) {
	global $b;
	$H = $b->dumpHeaders($Gd, $Ze);
	$Pf = $_POST["output"];
	if ($Pf != "text") header("Content-Disposition: attachment; filename=" . $b->dumpFilename($Gd) . ".$H" . ($Pf != "file" && !preg_match('~[^0-9a-z]~', $Pf) ? ".$Pf" : ""));
	session_write_close();
	ob_flush();
	flush();
	return $H;
}

function
dump_csv($I) {
	foreach ($I
			 as $y => $X) {
		if (preg_match("~[\"\n,;\t]~", $X) || $X === "") $I[$y] = '"' . str_replace('"', '""', $X) . '"';
	}
	echo
		implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $I) . "\r\n";
}

function
apply_sql_function($r, $e) {
	return ($r ? ($r == "unixepoch" ? "DATETIME($e, '$r')" : ($r == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$r(")) . "$e)") : $e);
}

function
get_temp_dir() {
	$H = ini_get("upload_tmp_dir");
	if (!$H) {
		if (function_exists('sys_get_temp_dir')) $H = sys_get_temp_dir(); else {
			$Yc = @tempnam("", "");
			if (!$Yc) return
				false;
			$H = dirname($Yc);
			unlink($Yc);
		}
	}
	return $H;
}

function
file_open_lock($Yc) {
	$md = @fopen($Yc, "r+");
	if (!$md) {
		$md = @fopen($Yc, "w");
		if (!$md) return;
		chmod($Yc, 0660);
	}
	flock($md, LOCK_EX);
	return $md;
}

function
file_write_unlock($md, $Pb) {
	rewind($md);
	fwrite($md, $Pb);
	ftruncate($md, strlen($Pb));
	flock($md, LOCK_UN);
	fclose($md);
}

function
password_file($Hb) {
	$Yc = get_temp_dir() . "/adminer.key";
	$H = @file_get_contents($Yc);
	if ($H || !$Hb) return $H;
	$md = @fopen($Yc, "w");
	if ($md) {
		chmod($Yc, 0660);
		$H = rand_string();
		fwrite($md, $H);
		fclose($md);
	}
	return $H;
}

function
rand_string() {
	return
		md5(uniqid(mt_rand(), true));
}

function
select_value($X, $_, $o, $ii) {
	global $b;
	if (is_array($X)) {
		$H = "";
		foreach ($X
				 as $he => $W) $H .= "<tr>" . ($X != array_values($X) ? "<th>" . h($he) : "") . "<td>" . select_value($W, $_, $o, $ii);
		return "<table cellspacing='0'>$H</table>";
	}
	if (!$_) $_ = $b->selectLink($X, $o);
	if ($_ === null) {
		if (is_mail($X)) $_ = "mailto:$X";
		if (is_url($X)) $_ = $X;
	}
	$H = $b->editVal($X, $o);
	if ($H !== null) {
		if (!is_utf8($H)) $H = "\0"; elseif ($ii != "" && is_shortable($o)) $H = shorten_utf8($H, max(0, +$ii));
		else$H = h($H);
	}
	return $b->selectVal($H, $_, $o, $X);
}

function
is_mail($uc) {
	$Ia = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
	$hc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
	$fg = "$Ia+(\\.$Ia+)*@($hc?\\.)+$hc";
	return
		is_string($uc) && preg_match("(^$fg(,\\s*$fg)*\$)i", $uc);
}

function
is_url($P) {
	$hc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
	return
		preg_match("~^(https?)://($hc?\\.)+$hc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $P);
}

function
is_shortable($o) {
	return
		preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $o["type"]);
}

function
count_rows($Q, $Z, $ce, $rd) {
	global $x;
	$F = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
	return ($ce && ($x == "sql" || count($rd) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $rd) . ")$F" : "SELECT COUNT(*)" . ($ce ? " FROM (SELECT 1$F GROUP BY " . implode(", ", $rd) . ") x" : $F));
}

function
slow_query($F) {
	global $b, $ti, $m;
	$l = $b->database();
	$ki = $b->queryTimeout();
	$yh = $m->slowQuery($F, $ki);
	if (!$yh && support("kill") && is_object($i = connect()) && ($l == "" || $i->select_db($l))) {
		$me = $i->result(connection_id());
		echo '<script', nonce(), '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME), 'script=kill\', function () {
	}, \'kill=', $me, '&token=', $ti, '\');
}, ', 1000 * $ki, ');
</script>
';
	} else$i = null;
	ob_flush();
	flush();
	$H = @get_key_vals(($yh ? $yh : $F), $i, false);
	if ($i) {
		echo
		script("clearTimeout(timeout);");
		ob_flush();
		flush();
	}
	return $H;
}

function
get_token() {
	$Cg = rand(1, 1e6);
	return ($Cg ^ $_SESSION["token"]) . ":$Cg";
}

function
verify_token() {
	list($ti, $Cg) = explode(":", $_POST["token"]);
	return ($Cg ^ $_SESSION["token"]) == $ti;
}

function
lzw_decompress($Ta) {
	$ec = 256;
	$Ua = 8;
	$nb = array();
	$Sg = 0;
	$Tg = 0;
	for ($s = 0; $s < strlen($Ta); $s++) {
		$Sg = ($Sg << 8) + ord($Ta[$s]);
		$Tg += 8;
		if ($Tg >= $Ua) {
			$Tg -= $Ua;
			$nb[] = $Sg >> $Tg;
			$Sg &= (1 << $Tg) - 1;
			$ec++;
			if ($ec >> $Ua) $Ua++;
		}
	}
	$dc = range("\0", "\xFF");
	$H = "";
	foreach ($nb
			 as $s => $mb) {
		$tc = $dc[$mb];
		if (!isset($tc)) $tc = $rj . $rj[0];
		$H .= $tc;
		if ($s) $dc[] = $rj . $tc[0];
		$rj = $tc;
	}
	return $H;
}

function
on_help($tb, $vh = 0) {
	return
		script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $tb, $vh) }, onmouseout: helpMouseout});", "");
}

function
edit_form($a, $p, $I, $Oi) {
	global $b, $x, $ti, $n;
	$Uh = $b->tableName(table_status1($a, true));
	page_header(($Oi ? lang(10) : lang(11)), $n, array("select" => array($a, $Uh)), $Uh);
	if ($I === false) echo "<p class='error'>" . lang(12) . "\n";
	echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
	if (!$p) echo "<p class='error'>" . lang(13) . "\n"; else {
		echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
		foreach ($p
				 as $B => $o) {
			echo "<tr><th>" . $b->fieldName($o);
			$Wb = $_GET["set"][bracket_escape($B)];
			if ($Wb === null) {
				$Wb = $o["default"];
				if ($o["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $Wb, $Mg)) $Wb = $Mg[1];
			}
			$Y = ($I !== null ? ($I[$B] != "" && $x == "sql" && preg_match("~enum|set~", $o["type"]) ? (is_array($I[$B]) ? array_sum($I[$B]) : +$I[$B]) : $I[$B]) : (!$Oi && $o["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $Wb)));
			if (!$_POST["save"] && is_string($Y)) $Y = $b->editVal($Y, $o);
			$r = ($_POST["save"] ? (string)$_POST["function"][$B] : ($Oi && preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
			if (preg_match("~time~", $o["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
				$Y = "";
				$r = "now";
			}
			input($o, $Y, $r);
			echo "\n";
		}
		if (!support("table")) echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $b->editFunctions(array("null" => isset($_GET["select"])))) . "<td><input name='field_vals[]'>" . "\n";
		echo "</table>\n";
	}
	echo "<p>\n";
	if ($p) {
		echo "<input type='submit' value='" . lang(14) . "'>\n";
		if (!isset($_GET["select"])) {
			echo "<input type='submit' name='insert' value='" . ($Oi ? lang(15) : lang(16)) . "' title='Ctrl+Shift+Enter'>\n", ($Oi ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . lang(17) . "…', this); };") : "");
		}
	}
	echo($Oi ? "<input type='submit' name='delete' value='" . lang(18) . "'>" . confirm() . "\n" : ($_POST || !$p ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
	if (isset($_GET["select"])) hidden_fields(array("check" => (array)$_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]));
	echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]), '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $ti, '">
</form>
';
}

if (isset($_GET["file"])) {
	if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: immutable");
	if ($_GET["file"] == "favicon.ico") {
		header("Content-Type: image/x-icon");
		echo
		lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
	} elseif ($_GET["file"] == "default.css") {
		header("Content-Type: text/css; charset=utf-8");
		echo
		lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7�����t4���y�Zf4��i�AT�VV��f:Ϧ,:1�Qݼ�b2`�#�>:7G�1���s��L�XD*bv<܌#�e@�:4�!fo���t:<��咾�o��\ni���',�a_�:�i�Bv�|N�4.5Nf�i�vp�h��l��֚�O����= �OFQ��k\$��i����d2T�p��6�����-�Z�����6����h:�a�,����2�#8А�#��6n����J��h�t�����4O42��ok��*r���@p@�!������?�6��r[��L���:2B�j�!Hb��P�=!1V�\"��0��\nS���D7��Dڛ�C!�!��Gʌ� �+�=tC�.C��:+��=�������%�c�1MR/�EȒ4���2�䱠�`�8(�ӹ[W��=�yS�b�=�-ܹBS+ɯ�����@pL4Yd��q�����6�3Ĭ��Ac܌�Ψ�k�[&>���Z�pkm]�u-c:���Nt�δpҝ��8�=�#��[.��ޯ�~���m�y�PP�|I֛���Q�9v[�Q��\n��r�'g�+��T�2��V��z�4��8��(	�Ey*#j�2]��R����)��[N�R\$�<>:�>\$;�>��\r���H��T�\nw�N �wأ��<��Gw����\\Y�_�Rt^�>�\r}��S\rz�4=�\nL�%J��\",Z�8����i�0u�?�����s3#�ى�:���㽖��E]x���s^8��K^��*0��w����~���:��i���v2w����^7���7�c��u+U%�{P�*4̼�LX./!��1C��qx!H��Fd��L���Ġ�`6��5��f��Ć�=H�l �V1��\0a2�;��6����_ه�\0&�Z�S�d)KE'��n��[X��\0ZɊ�F[P�ޘ@��!��Y�,`�\"ڷ��0Ee9yF>��9b����F5:���\0}Ĵ��(\$����37H��� M�A��6R��{Mq�7G��C�C�m2�(�Ct>[�-t�/&C�]�etG�̬4@r>���<�Sq�/���Q�hm���������L��#��K�|���6fKP�\r%t��V=\"�SH\$�} ��)w�,W\0F��u@�b�9�\rr�2�#�D��X���yOI�>��n��Ǣ%���'��_��t\rτz�\\1�hl�]Q5Mp6k���qh�\$�H~�|��!*4����`S���S t�PP\\g��7�\n-�:袪p����l�B���7Өc�(wO0\\:��w���p4���{T��jO�6HÊ�r���q\n��%%�y']\$��a�Z�.fc�q*-�FW��k��z���j���lg�:�\$\"�N�\r#�d�Â���sc�̠��\"j�\r�����Ւ�Ph�1/��DA)���[�kn�p76�Y��R{�M�P���@\n-�a�6��[�zJH,�dl�B�h�o�����+�#Dr^�^��e��E��� ĜaP���JG�z��t�2�X�����V�����ȳ��B_%K=E��b弾�§kU(.!ܮ8����I.@�K�xn���:�P�32��m�H		C*�:v�T�\nR�����0u�����ҧ]�����P/�JQd�{L�޳:Y��2b��T ��3�4���c�V=���L4��r�!�B�Y�6��MeL������i�o�9< G��ƕЙMhm^�U�N����Tr5HiM�/�n�흳T��[-<__�3/Xr(<���������uҖGNX20�\r\$^��:'9�O��;�k����f��N'a����b�,�V��1��HI!%6@��\$�EGڜ�1�(mU��rս���`��iN+Ü�)���0l��f0��[U��V��-:I^��\$�s�b\re��ug�h�~9�߈�b�����f�+0�� hXrݬ�!\$�e,�w+����3��_�A�k��\nk�r�ʛcuWdY�\\�={.�č���g��p8�t\rRZ�v�J:�>��Y|+�@����C�t\r��jt��6��%�?��ǎ�>�/�����9F`ו��v~K�����R�W��z��lm�wL�9Y�*q�x�z��Se�ݛ����~�D�����x���ɟi7�2���Oݻ��_{��53��t���_��z�3�d)�C��\$?KӪP�%��T&��&\0P�NA�^�~���p� �Ϝ���\r\$�����b*+D6궦ψ��J\$(�ol��h&��KBS>���;z��x�oz>��o�Z�\nʋ[�v���Ȝ��2�OxِV�0f�����2Bl�bk�6Zk�hXcd�0*�KT�H=��π�p0�lV����\r���n�m��)(�(�:#����E��:C�C���\r�G\ré0��i����:`Z1Q\n:��\r\0���q���:`�-�M#}1;����q�#|�S���hl�D�\0fiDp�L��``����0y��1���\r�=�MQ\\��%oq��\0��1�21�1�� ���ќbi:��\r�/Ѣ� `)��0��@���I1�N�C�����O��Z��1���q1 ����,�\rdI�Ǧv�j�1 t�B���⁒0:�0��1�A2V���0���%�fi3!&Q�Rc%�q&w%��\r��V�#���Qw`�% ���m*r��y&i�+r{*��(rg(�#(2�(��)R@i�-�� ���1\"\0��R���.e.r��,�ry(2�C��b�!Bޏ3%ҵ,R�1��&��t��b�a\rL��-3�����\0��Bp�1�94�O'R�3*��=\$�[�^iI;/3i�5�&�}17�# ѹ8��\"�7��8�9*�23�!�!1\\\0�8��rk9�;S�23��ړ*�:q]5S<��#3�83�#e�=�>~9S螳�r�)��T*a�@і�bes���:-���*;,�ؙ3!i���LҲ�#1 �+n� �*��@�3i7�1���_�F�S;3�F�\rA��3�>�x:� \r�0��@�-�/��w��7��S�J3� �.F�\$O�B���%4�+t�'g�Lq\rJt�J��M2\r��7��T@���)ⓣd��2�P>ΰ��Fi಴�\nr\0��b�k(�D���KQ����1�\"2t����P�\r��,\$KCt�5��#��)��P#Pi.�U2�C�~�\"�");
	} elseif ($_GET["file"] == "functions.js") {
		header("Content-Type: text/javascript; charset=utf-8");
		echo
		lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�|\nC(�\"��P���.��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�/��6KU����<2�pOI���`���ⳈdO�H��5�-��4��pX25-Ң�ۈ�z7��\"(�P�\\32:]U����߅!]�<�A�ۤ���iڰ�l\r�\0v��#J8��wm��ɤ�<�ɠ��%m;p#�`X�D���iZ��N0����9��占��`��wJ�D��2�9t��*��y��NiIh\\9����:����xﭵyl*�Ȉ��Y�����8�W��?���ޛ3���!\"6�n[��\r�*\$�Ƨ�nzx�9\r�|*3ףp�ﻶ�:(p\\;��mz���9����8N���j2����\r�H�H&��(�z��7i�k� ����c��e���t���2:SH�Ƞ�/)�x�@��t�ri9����8����yҷ���V�+^Wڦ��kZ�Y�l�ʣ���4��Ƌ������\\E�{�7\0�p���D��i�-T����0l�%=���˃9(�5�\n\n�n,4�\0�a}܃.��Rs\02B\\�b1�S�\0003,�XPHJsp�d�K� CA!�2*W����2\$�+�f^\n�1����zE� Iv�\\�2��.*A���E(d���b��܄��9����Dh�&��?�H�s�Q�2�x~nÁJ�T2�&��eR���G�Q��Tw�ݑ��P���\\�)6�����sh\\3�\0R	�'\r+*;R�H�.�!�[�'~�%t< �p�K#�!�l���Le����,���&�\$	��`��CX��ӆ0֭����:M�h	�ڜG��!&3�D�<!�23��?h�J�e ��h�\r�m���Ni�������N�Hl7��v��WI�.��-�5֧ey�\rEJ\ni*�\$@�RU0,\$U�E����ªu)@(t�SJk�p!�~���d`�>��\n�;#\rp9�jɹ�]&Nc(r���TQU��S��\08n`��y�b���L�O5��,��>���x���f䴒���+��\"�I�{kM�[\r%�[	�e�a�1! ���Ԯ�F@�b)R��72��0�\nW���L�ܜҮtd�+���0wgl�0n@��ɢ�i�M��\nA�M5n�\$E�ױN��l�����%�1 A������k�r�iFB���ol,muNx-�_�֤C( ��f�l\r1p[9x(i�BҖ��zQl��8C�	��XU Tb��I�`�p+V\0��;�Cb��X�+ϒ�s��]H��[�k�x�G*�]�awn�!�6�����mS�I��K�~/�ӥ7��eeN��S�/;d�A�>}l~��� �%^�f�آpڜDE��a��t\nx=�kЎ�*d���T����j2��j��\n��� ,�e=��M84���a�j@�T�s���nf��\n�6�\rd��0���Y�'%ԓ��~	�Ҩ�<���AH�G��8���΃\$z��{���u2*��a��>�(w�K.bP�{��o��´�z�#�2�8=�8>���A,�e���+�C�x�*���-b=m���,�a��lzk���\$W�,�m�Ji�ʧ���+���0�[��.R�sK���X��ZL��2�`�(�C�vZ������\$�׹,�D?H��NxX��)��M��\$�,��*\nѣ\$<q�şh!��S����xsA!�:�K��}�������R��A2k�X�p\n<�����l���3�����VV�}�g&Yݍ!�+�;<�Y��YE3r�َ��C�o5����ճ�kk�����ۣ��t��U���)�[����}��u��l�:D��+Ϗ _o��h140���0��b�K�㬒�����lG��#��������|Ud�IK���7�^��@��O\0H��Hi�6\r����\\cg\0���2�B�*e��\n��	�zr�!�nWz&� {H��'\$X �w@�8�DGr*���H�'p#�Į���\nd���,���,�;g~�\0�#����E��\r�I`��'��%E�.�]`�Л��%&��m��\r��%4S�v�#\n��fH\$%�-�#���qB�����Q-�c2���&���]�� �qh\r�l]�s���h�7�n#����-�jE�Fr�l&d����z�F6����\"���|���s@����z)0rpڏ\0�X\0���|DL<!��o�*�D�{.B<E���0nB(� �|\r\n�^���� h�!���r\$��(^�~����/p�q��B��O����,\\��#RR��%���d�Hj�`����̭ V� bS�d�i�E���oh�r<i/k\$-�\$o��+�ŋ��l��O�&evƒ�i�jMPA'u'���( M(h/+��WD�So�.n�.�n���(�(\"���h�&p��/�/1D̊�j娸E��&⦀�,'l\$/.,�d���W�bbO3�B�sH�:J`!�.���������,F��7(��Կ��1�l�s �Ҏ���Ţq�X\r����~R鰱`�Ҟ�Y*�:R��rJ��%L�+n�\"��\r��͇H!qb�2�Li�%����Wj#9��ObE.I:�6�7\0�6+�%�.����a7E8VS�?(DG�ӳB�%;���/<�����\r ��>�M��@���H�Ds��Z[tH�Enx(���R�x��@��GkjW�>���#T/8�c8�Q0��_�IIGII�!���YEd�E�^�td�th�`DV!C�8��\r���b�3�!3�@�33N}�ZB�3	�3�30��M(�>��}�\\�t�f�f���I\r���337 X�\"td�,\nbtNO`P�;�ܕҭ���\$\n����Zѭ5U5WU�^ho���t�PM/5K4Ej�KQ&53GX�Xx)�<5D��\r�V�\n�r�5b܀\\J\">��1S\r[-��Du�\r���)00�Y��ˢ�k{\n��#��\r�^��|�uܻU�_n�U4�U�~Yt�\rI��@䏳�R �3:�uePMS�0T�wW�X���D��KOU����;U�\n�OY��Y�Q,M[\0�_�D���W��J*�\rg(]�\r\"ZC��6u�+�Y��Y6ô�0�q�(��8}��3AX3T�h9j�j�f�Mt�PJbqMP5>������Y�k%&\\�1d��E4� �Yn���\$<�U]Ӊ1�mbֶ�^�����\"NV��p��p��eM���W�ܢ�\\�)\n �\nf7\n�2��r8��=Ek7tV����7P��L��a6��v@'�6i��j&>��;��`��a	\0pڨ(�J��)�\\��n��Ĭm\0��2��eqJ��P��t��fj��\"[\0����X,<\\������+md��~�����s%o��mn�),ׄ�ԇ�\r4��8\r����mE�H]�����HW�M0D�߀��~�ˁ�K��E}����|f�^���\r>�-z]2s�xD�d[s�t�S��\0Qf-K`���t���wT�9��Z��	�\nB�9 Nb��<�B�I5o�oJ�p��JNd��\r�hލ��2�\"�x�HC�ݍ�:���9Yn16��zr+z���\\�����m ��T ���@Y2lQ<2O+�%��.Ӄh�0A���Z��2R��1��/�hH\r�X��aNB&� �M@�[x��ʮ���8&L�V͜v�*�j�ۚGH��\\ٮ	���&s�\0Q��\\\"�b��	��\rBs��w��	���BN`�7�Co(���\nè���1�9�*E� �S��U�0U� t�'|�m���?h[�\$.#�5	 �	p��yB�@R�]���@|��{���P\0x�/� w�%�EsBd���CU�~O׷�P�@X�]����Z3��1��{�eLY���ڐ�\\�(*R`�	�\n������QCF�*�����霬�p�X|`N���\$�[���@�U������Z�`Zd\"\\\"����)��I�:�t��oD�\0[�����-���g���*`hu%�,����I�7ī�H�m�6�}��N�ͳ\$�M�UYf&1����e]pz���I��m�G/� �w �!�\\#5�4I�d�E�hq���Ѭk�x|�k�qD�b�z?���>���:��[�L�ƬZ�X��:�������j�w5	�Y��0 ���\$\0C��dSg����{�@�\n`�	���C ���M�����# t}x�N����{�۰)��C��FKZ�j��\0PFY�B�pFk��0<�>�D<JE��g\r�.�2��8�U@*�5fk��JD���4��TDU76�/��@��K+���J�����@�=��WIOD�85M��N�\$R�\0�5�\r��_���E���I�ϳN�l���y\\����qU��Q���\n@���ۺ�p���P۱�7ԽN\r�R{*�qm�\$\0R��ԓ���q�È+U@�B��Of*�Cˬ�MC��`_ ���˵N��T�5٦C׻� ��\\W�e&_X�_؍h���B�3���%�FW���|�Gޛ'�[�ł����V��#^\r��GR����P��Fg�����Yi ���z\n��+�^/�������\\�6��b�dmh��@q���Ah�),J��W��cm�em]�ӏe�kZb0�����Y�]ym��f�e�B;���O��w�apDW�����{�\0��-2/bN�sֽ޾Ra�Ϯh&qt\n\"�i�Rm�hz�e����FS7��PP�䖤��:B����sm��Y d���7}3?*�t����lT�}�~�����=c������	��3�;T�L�5*	�~#�A����s�x-7��f5`�#\"N�b��G����@�e�[�����s����-��M6��qq� h�e5�\0Ң���*�b�IS���Fή9}�p�-��`{��ɖkP�0T<��Z9�0<՚\r��;!��g�\r\nK�\n��\0��*�\nb7(�_�@,�e2\r�]�K�+\0��p C\\Ѣ,0�^�MЧ����@�;X\r��?\$\r�j�+�/��B��P�����J{\"a�6�䉜�|�\n\0��\\5���	156�� .�[�Uد\0d��8Y�:!���=��X.�uC����!S���o�p�B���7��ů�Rh�\\h�E=�y:< :u��2�80�si��TsB�@\$ ��@�u	�Q���.��T0M\\/�d+ƃ\n��=��d���A���)\r@@�h3���8.eZa|.�7�Yk�c���'D#��Y�@X�q�=M��44�B AM��dU\"�Hw4�(>��8���C�?e_`��X:�A9ø���p�G��Gy6��F�Xr��l�1��ػ�B�Å9Rz��hB�{����\0��^��-�0�%D�5F\"\"�����i�`��nAf� \"tDZ\"_�V\$��!/�D�ᚆ������٦�̀F,25�j�T��y\0�N�x\r�Yl��#��Eq\n��B2�\n��6���4���!/�\n��Q��*�;)bR�Z0\0�CDo�˞�48������e�\n�S%\\�PIk��(0��u/��G������\\�}�4Fp��G�_�G?)g�ot��[v��\0��?b�;��`(�ی�NS)\n�x=��+@��7��j�0��,�1Åz����>0��Gc��L�VX�����%����Q+���o�F���ܶ�>Q-�c���l����w��z5G��@(h�c�H��r?��Nb�@�������lx3�U`�rw���U���t�8�=�l#���l�䨉8�E\"����O6\n��1e�`\\hKf�V/зPaYK�O�� ��x�	�Oj���r7�F;��B����̒��>�Ц�V\rĖ�|�'J�z����#�PB��Y5\0NC�^\n~LrR��[̟Rì�g�eZ\0x�^�i<Q�/)�%@ʐ��fB�Hf�{%P�\"\"���@���)���DE(iM2�S�*�y�S�\"���e̒1��ט\n4`ʩ>��Q*��y�n����T�u�����~%�+W��XK���Q�[ʔ��l�PYy#D٬D<�FL���@�6']Ƌ��\rF�`�!�%\n�0�c���˩%c8WrpG�.T�Do�UL2�*�|\$�:�Xt5�XY�I�p#� �^\n��:�#D�@�1\r*�K7�@D\0��C�C�xBh�EnK�,1\"�*y[�#!�י�ٙ���l_�/��x�\0���5�Z��4\0005J�h\"2���%Y���a�a1S�O�4��%ni��P��ߴq�_ʽ6���6��\n@PjU�\0��`r;�H�������:�����4 _w*�@F@%��s[�d�e���bh�\0�ɱP\r�\\i�J�99P9�^s�.��P29�\nNj#,����5���M)��B���\ni%~����:9��X\r�e��8���eӽ+���9���x�*�ـW2�N�ba�S�E��2��\r����p�	��\\(/	Lf����Y��X#8ZJăH��+P�-I1xɈ�36�N�w\r���[x3�>\rTO�b�>s��0���jA�8;�#ј������jPd�qR�J�\"��(x����h�*��	T��aV��Yƌ��\$����7�Z9ĸ�1̚XJ���a�AOk8fD�C�96@���M�(H�����B���?�i�TAPܭ�^0�P��af/�ύ�P0�MH)\"�dU@�r1\\�\r�oH|�����h�8�@�?P��Z,A>®��E(�&��e��͞]�Q\$������ЪZ�}a���̙:P�w:��(�Z���!8������n@9�\$��(K\"����%Ŧ��@2��\$P��<��\0��灦JtUXP\"-A��ɦYk�2����4�C\n�\0���2��~�s_��\0�N5��Ҝ��/�ӀI�;���i���֗efkF<�r�E�,�6%?�I�j;'S)M����4)�N�.�~�����\0J�Ӕ��3��Qzz	�?��m1����q�	cQH�ܯyL\"Oυ0|c\$P�\"����r0eL��m#d�px.uA�^�B�76��qn�׍�B�n��iZvR@�)*�㌁qƒ�)��7^�I��jI�S5�3�������8ں���x�9	�Lq��L�OA�A\0001���%�!1-�W��Ҏ�%#!5+�����!�vue(�Bp�\nK�/������\\�i���\0^�\$�,�|�Z��(R�+k��\n++��V�G�{/�T�<��M�ê��¢���\$�{д�̀y�Vt� +�S�Z���(u� x\"HC�J�? v8�J�P� Q\0�V1��#��'_�\n�4%�ǥ\nza_���PDD{��+\$Sz�օ? l�ʍ��2z��!=�OD���[�b\0�K�Į�tj�+�(�Ҕ5�.��k�Z�F֭=A���Uך��0�C�������~�v.�8�+Rx[�º�زŦ�Au��I8䬎3���� '	�i�f��.J�ʈT���X11����&3��6���	��f@|O`b��g\0�>���x�kkMD�Q�\n����h����a�y\$t��`\"��5����56���| `&���:T�A��\n������pjR���I*��Q�����aN�Z�_Z�q⴩����G9\0�����(İ=J��� dG���9r��,Qp�+kZ�\$��I+����(��5��{2��_m�ˆ8��e���n����\\6Ŋ���\${X��K\$��#k�U��+v�vE�m�n��vO�	!Adt��_/�(6�1ڕ��m[�����\$�Tαh�d��X�����/7ꠡB� �-\$��Ur�>b*)̶Z�Xnb�\n��ESΝpoe����p\\��D� ��E�#�,��T~�.�P��m)a��=óR���E��<��r�6��gHE-t�봺R�v�ZtF+m[���u�:��7w��]��,`��-�w��9���a���o���[DM������oe�rq6�H���Ș!*�teh���^�ʔ��I��M�đ\"DA��\$�\0oH��̜�Ap��E�ZL���}\"��:�|��6�|=n����f�c���v�J]�A5c�H��8��-�����O�VBV�#д��`���\r���-�	�KBd�G�^�+��.��El��\$\$(q�0|9(��h��{\n4a7B�P\0n@-h�oW���� `�+^j��d��9cP�q1��H\"���\\�����!���\".ڤ�����E<�/���z}���(�XD.6?Nxk*,)�l�W�9�	j\\I��(J���@;�1����\n�Ix��ï�h\rI[:��ˈH�5/�vBu�Pfu��6�!4�xl��2�����^ ��g\0�����_q��~4I�O\"�-x�D��b\\\"�-_�rȔ���G\"�b�a{O���R�v�r�qK�\0\$�m�b���NAt@�)U�𣰮��p�j��v��,9�ʄ��*T~�L���dѻ�K�g��P�L����F�2���P*,uW��*Z����UpU�i\0d�]��\rGw\n@`����k�!�q�g��E��HE�@��]y2s��e��%���\"���\\�O�?�z+���4�;uzЁ0d7��F����<d��2�u�9���W\$y9��\0P܀d�,�-���[����h|BQ ��5ҙ���ة�<��r\0�t;2����f�9T��=@�s:��ɘ��L�v���X@WoN �W��\$D�D7��e����:(�v�����/����r\rA�Ơ\n�z3|�٘��z^ev/�y��^5��G��0B�����m�`��vl���n�n�R>\nYTc��b��P\\�rPc�cx7c���D�={*�dr��8��w�΁܆=R6_��Ɯ�Ny��`&��\$�H��G�k�4Y|��/�ٳ�@��Ҥ�sέ������R\"y�[�zGo�%Gg����{�ϟ�.���9r�c�\\U����5��C����\"��)L׌�I���k��\r��i��(�Ϲ-���\\d��&r�|�f����P�eM�I��bc0Ml�C���OZ9�&��z�������HK�X�Ў�%��AauR���w�I=�KY���De��̀\r�ވ1�D�\"OmuL�o�C\\�m!�s�T\0�t���|�uK��)���貅Z2�XoM|C���h/���➁!�FԨ�(���J�\0�H�Sz3��(f�J�4ޣ�8�cb�\$��۩R��`���i�޺�.\0��?�l�[6�D��Hֆ��R[��e<q�����;�������pKtf`/���Ԥz\rݫ-Mi�͢L�J��,��JC��� ��f��ӧ[�����ڲ,-Yڇ]!y nT���Bl�ބ\$zUcu��\$�j>72�,4.���!��Q��D+�F���ן��[\n6�So8�M)�Leٴ��\r,�e=�\r�����-�h��#�M�*=O���\n��#D���Q�+a�O��-Ss1+[@(���3|���r��F�拄=iJ���2&�s�\rO�\$!l��D����Bt��i��Rq;͉@�P���WP>?�=r�ןnCs,���;B�o��M�m�}��y��M�����˹-���>y,g�6�q���\"�q3|d��;��b�F7�	늫@��?��v@	��ERU� �&I\\}-X����gG4�]g6��Ԃ>��\0�:��\"jWP�{�g���O\\3����\n��\r� ��,�Dߢ�9�\0	�O}jCڷ�L��|	H��6�����r�TF������!��S+�r�����c3��B@XdT6&��ǎG�g�n�8�Ƒ�z|)���V��^��	��-\0�8���-�8b�7�-�/�@�֐>V���+u\0B�zl%5׶��OJ���!��ֲ@�x�h�7 �!�1�8�SR�\0Q*o�8�n*�?_���\nx���T�9�������n�4,7o�^�N]�d�q�1#e�(v������,���ms.8�T�WgB>`�L�@���\\�y��n\nNq���1�E=h4<Ӿ\$�sA��u3�B���:�@�u�2�A=��\\B-uM��DnW�d�V��TlrR����Ҟ�Ug�\r��������{F�>A�C��'�	��2�������b�����b���d�Y/�|nr\r��S�Sk*�AO��R)��;�s�Ԕ\$w\$)E��Ai�鰠�Q 1�ݔ���D3%�� ���*2r��PL�s,�;�ug+��t�h�b�L���%��rC�|�Z����N�*��*5;ۡ�U�A�{І��~y�iKX��ڔD��#�2CJY��������>zS�CU��c����ORԾ�0�)�+��:-IN����|�e�G�;�b��\$,p0��_L.��\$ċ�v��SܖF1&U��(	��nxt���d�@0��������/wc��_R�2�f�ѭeĪ�\0=��s��bsCO4�t~�h�(�o}OU����_h���p������x��\$?!�Bw�G�9�G��渦���V?{X�n�S�~��_1��Ţq��U{#x\nN \$�8�E��q�~��7�!��i!�n�qi\r\$��k𨞣��Q��Ld	�S��tpA9��/[�s�\0��6Vv,�������'�`�?C�s�hctH\"�K�}n���'������^�3���_M�%�o���郄�VO��ٿ����E�\n��rpT��L��|`e�Ѻ���A�j�:d|[�ێ⽌���J���4�l N�u4]l�M�H&��\$�\0YR��qzWĘ@������e3�'t|��.���`(�I<��2�_5�)%����G��m\0P\n�m�o@��>���xB\"��Em|��2�\$},3L�YX�go�\$߶ <�����IE\"`���4�g�8^�]\n����:��qV�Tԣ�m�m��7&ғĤ�m��&���Qz�������ű�H����yO�f��\r٣.�����@�JW&�q�5�0	�5��P�G��\n����F�{\0\r�m�@�@ �P� x�4i4�+@\0,͚\\�C1ӎ�\n�L���>n�\0���	 #������#@]/4JR� IR��p�<�ǯ�aj��?)Mv�2X|@v\0a��\"�τ��k���-�yA[|�7\r��\$����ZǭR�t���>����CErL	��r�O�e�R/���J��~�%Xo�4�dU\"�Qr��I�QD������QQM}�Q�{)ة�\",f��_(,�6�Q+c����&�S���~O�p�C���������V�����@1�[�<H/�~�\0^C��T���q_gP��pe��@B�������끠pȿ�)X��\0��ߔ��{�`�\0v������Q����@~�翡����TƁW������������������O�>�8&����CLݑ��(���(���Ǐ2��\r%�;�k抐4��_O;�5��`@<���/�7�_	�6'AY��\"��aS��z�kp�4�+h@Z����8>���oߔL������j�s���\rJ��m��\0L\0c�?���m��N�(����Tp#���|�>����A[?�[�ſ�Hk�����\n�t��p:�G���>��T�{*��-�t����P��X�j�N�4���0\n\$��:H,�H}�A���c�*���n?�돢\n���;�O�\0Z��v�AB���`�o��8_�R--n��T#DIs1��\0V�PM\0V�r���0\$Bi�`�T�d�X|e\08\\�7),_���K�3(.c��\\�d��2���R<�u�\\��	4�N�(|g���|�N&,����y���(���8b�:P���1Y'!��Ą�\0fx���\0��1����H[,�>����&�T�/a\rLC�bE����	7����b��kș�|b��0�T\"���.���ق5s��D�Sg�8�Rh*�4�}�����<-9B\$���d9B\$�i�H�8cj\\`���_�����	�#`��h����HΨp�\$�0�`1W\n��%N�Z\\#�b��P��%m7l\"��d��\"P��!�#/ş��,ͪ��J#0��c�]��-(򐹆6�7l~�\r\0B��0�:CA�\\pϑ�[����(Ќ�JG�0�B\"8�P�B*%�<#�BF72�B������5Bp	t&��6\0b���4<\$퀶�K��V\0G	�mY�");
	} elseif ($_GET["file"] == "jush.js") {
		header("Content-Type: text/javascript; charset=utf-8");
		echo
		lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O���/�<�x�9�o�����3n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��㢺�>�8�\$�c��1�c���c����{n7����A�N�RLi\r1���!�(�j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mplv�)� ��HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f������\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g��U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��yŊ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL�pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)���\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j���Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9O\$��طzyM�3�\\9���.o�����E(i������7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~����)TZ0E9M�YZtXe!�f�@�{Ȭyl	8�;���R{��8�Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��jG���t�*3%k�YܲT*�|\"C��lhE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+�����̷�^�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�)���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�=MƂ0n�P�/p�ot������.�̽�g\0�)o�\n0���\rF����b�i��o}\n�̯�	NQ�'�x�Fa�J���L������\r��\r����0��'��d	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���n!�Ɏ�z�����\\��\r���`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v���N�͐f��@܆�&�B\$�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} ��lb�&�vj4�LS��ִԶ5&dsF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQMTmGB�tl-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj���\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v�#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA������2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`�}M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU�cD�ѷ���X!��u�&-vP�ر\0'L�X �L����o	��>�Վ�\r@�P�\rxF��E��ȭ�%����=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y�����]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#�������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9���W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-��������J(���@�;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u��6�|�|X����س|O�x!�:���ϗY]�����c���\r�h�9n�������8'������\rS.1��USȸ��X��+��z]ɵ��?����C�\r��\\����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K��f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR&M���?�St�T]ݴG�:I����)��B�� v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ����lJ����y�I�	�:����B�bP���Z��n����U;>_�\n	�����`��uM򌂂�֍m����Lw�B\0\\b8�M��[z��&�1�\0�	�\r�T������+\\�3�Plb4-)%Wd#\n��r��MX\"ϡ�(Ei11(b`@f����S���j�D��bf�}�r����D�R1���b��A��Iy\"�Wv��gC�I�J8z\"P\\i�\\m~ZR��v�1ZB5I��i@x����-�uM\njK�U�h\$o��JϤ!�L\"#p7\0� P�\0�D�\$	�GK4e��\$�\nG�?�3�EAJF4�Ip\0��F�4��<f@� %q�<k�w��	�LOp\0�x��(	�G>�@�����9\0T����GB7�-�����G:<Q��#���Ǵ�1�&tz��0*J=�'�J>���8q��Х���	�O��X�F��Q�,����\"9��p�*�66A'�,y��IF�R��T���\"��H�R�!�j#kyF���e��z�����G\0�p��aJ`C�i�@�T�|\n�Ix�K\"��*��Tk\$c��ƔaAh��!�\"�E\0O�d�Sx�\0T	�\0���!F�\n�U�|�#S&		IvL\"����\$h���EA�N\$�%%�/\nP�1���{��) <���L���-R1��6���<�@O*\0J@q��Ԫ#�@ǵ0\$t�|�]�`��ĊA]���Pᑀ�C�p\\pҤ\0���7���@9�b�m�r�o�C+�]�Jr�f��\r�)d�����^h�I\\�. g��>���8���'�H�f�rJ�[r�o���.�v���#�#yR�+�y��^����F\0᱁�]!ɕ�ޔ++�_�,�\0<@�M-�2W���R,c���e2�*@\0�P ��c�a0�\\P���O���`I_2Qs\$�w��=:�z\0)�`�h�������\nJ@@ʫ�\0�� 6qT��4J%�N-�m����.ɋ%*cn��N�6\"\r͑�����f�A���p�MۀI7\0�M�>lO�4�S	7�c���\"�ߧ\0�6�ps�����y.��	���RK��PAo1F�tI�b*��<���@�7�˂p,�0N��:��N�m�,�xO%�!��v����gz(�M���I��	��~y���h\0U:��OZyA8�<2����us�~l���E�O�0��0]'�>��ɍ�:���;�/��w�����'~3GΖ~ӭ����c.	���vT\0c�t'�;P�\$�\$����-�s��e|�!�@d�Obw��c��'�@`P\"x����0O�5�/|�U{:b�R\"�0�шk���`BD�\nk�P��c��4�^ p6S`��\$�f;�7�?ls��߆gD�'4Xja	A��E%�	86b�:qr\r�]C8�c�F\n'ьf_9�%(��*�~��iS����@(85�T��[��Jڍ4�I�l=��Q�\$d��h�@D	-��!�_]��H�Ɗ�k6:���\\M-����\r�FJ>\n.��q�eG�5QZ����' ɢ���ہ0��zP��#������r���t����ˎ��<Q��T��3�D\\����pOE�%)77�Wt�[��@����\$F)�5qG0�-�W�v�`�*)Rr��=9qE*K\$g	��A!�PjBT:�K���!��H� R0?�6�yA)B@:Q�8B+J�5U]`�Ҭ��:���*%Ip9�̀�`KcQ�Q.B��Ltb��yJ�E�T��7���Am�䢕Ku:��Sji� 5.q%LiF��Tr��i��K�Ҩz�55T%U��U�IՂ���Y\"\nS�m���x��Ch�NZ�UZ���( B��\$Y�V��u@蔻����|	�\$\0�\0�oZw2Ҁx2���k\$�*I6I�n�����I,��QU4�\n��).�Q���aI�]����L�h\"�f���>�:Z�>L�`n�ض��7�VLZu��e��X����B���B�����Z`;���J�]�����S8��f \nڶ�#\$�jM(��ޡ����a�G��+A�!�xL/\0)	C�\n�W@�4�����۩� ��RZ����=���8�`�8~�h��P ��\r�	���D-FyX�+�f�QSj+X�|��9-��s�x�����+�V�cbp쿔o6H�q�����@.��l�8g�YM��WMP��U��YL�3Pa�H2�9��:�a�`��d\0�&�Y��Y0٘��S�-��%;/�T�BS�P�%f������@�F�(�֍*�q +[�Z:�QY\0޴�JUY֓/���pkzȈ�,�𪇃j�ꀥW�״e�J�F��VBI�\r��pF�Nقֶ�*ը�3k�0�D�{����`q��ҲBq�e�D�c���V�E���n����FG�E�>j�����0g�a|�Sh�7u�݄�\$���;a��7&��R[WX���(q�#���P���ז�c8!�H���VX�Ď�j��Z������Q,DUaQ�X0��ը���Gb��l�B�t9-oZ���L���­�pˇ�x6&��My��sҐ����\"�̀�R�IWU`c���}l<|�~�w\"��vI%r+��R�\n\\����][��6�&���ȭ�a�Ӻ��j�(ړ�Tѓ��C'��� '%de,�\n�FC�эe9C�N�Ѝ�-6�Ueȵ��CX��V������+�R+�����3B��ڌJ�虜��T2�]�\0P�a�t29��(i�#�aƮ1\"S�:�����oF)k�f���Ъ\0�ӿ��,��w�J@��V򄎵�q.e}KmZ����XnZ{G-���ZQ���}��׶�6ɸ���_�؁Չ�\n�@7�` �C\0]_ ��ʵ����}�G�WW: fCYk+��b۶���2S,	ڋ�9�\0﯁+�W�Z!�e��2������k.Oc��(v̮8�DeG`ۇ�L���,�d�\"C���B-�İ(����p���p�=����!�k������}(���B�kr�_R�ܼ0�8a%ۘL	\0���b������@�\"��r,�0T�rV>����Q��\"�r��P�&3b�P��-�x���uW~�\"�*舞�N�h�%7���K�Y��^A����C����p����\0�..`c��+ϊ�GJ���H���E����l@|I#Ac��D��|+<[c2�+*WS<�r��g���}��>i�݀�!`f8�(c����Q�=f�\n�2�c�h4�+q���8\na�R�B�|�R����m��\\q��gX����ώ0�X�`n�F���O p��H�C��jd�f��EuDV��bJɦ��:��\\�!mɱ?,TIa���aT.L�]�,J��?�?��FMct!a٧R�F�G�!�A���rr�-p�X��\r��C^�7���&�R�\0��f�*�A\n�՛H��y�Y=���l�<��A�_��	+��tA�\0B�<Ay�(fy�1�c�O;p���ᦝ`�4СM��*��f�� 5fvy {?���:y��^c��u�'���8\0��ӱ?��g��� 8B��&p9�O\"z���rs�0��B�!u�3�f{�\0�:�\n@\0����p���6�v.;�����b�ƫ:J>˂��-�B�hkR`-����aw�xEj����r�8�\0\\����\\�Uhm� �(m�H3̴�S����q\0��NVh�Hy�	��5�M͎e\\g�\n�IP:Sj�ۡٶ�<���x�&�L��;nfͶc�q��\$f�&l���i�����0%yΞ�t�/��gU̳�d�\0e:��h�Z	�^�@��1��m#�N��w@��O��zG�\$�m6�6}��ҋ�X'�I�i\\Q�Y���4k-.�:yz���H��]��x�G��3��M\0��@z7���6�-DO34�ދ\0Κ��ΰt\"�\"vC\"Jf�Rʞ��ku3�M��~����5V ��j/3���@gG�}D���B�Nq��=]\$�I��Ӟ�3�x=_j�X٨�fk(C]^j�M��F��ա��ϣCz��V��=]&�\r�A<	������6�Ԯ�״�`jk7:g��4ծ��YZq�ftu�|�h�Z��6��i〰0�?��骭{-7_:��ސtѯ�ck�`Y��&���I�lP`:�� j�{h�=�f	��[by��ʀoЋB�RS���B6��^@'�4��1U�Dq}��N�(X�6j}�c�{@8���,�	�PFC���B�\$mv���P�\"��L��CS�]����E���lU��f�wh{o�(��)�\0@*a1G� (��D4-c��P8��N|R���VM���n8G`e}�!}���p�����@_���nCt�9��\0]�u��s���~�r��#Cn�p;�%�>wu���n�w��ݞ�.���[��hT�{��值	�ˁ��J���ƗiJ�6�O�=������E��ٴ��Im���V'��@�&�{��������;�op;^��6Ŷ@2�l���N��M��r�_ܰ�Í�` �( y�6�7�����ǂ��7/�p�e>|��	�=�]�oc����&�xNm���烻��o�G�N	p����x��ý���y\\3����'�I`r�G�]ľ�7�\\7�49�]�^p�{<Z��q4�u�|��Qۙ��p���i\$�@ox�_<���9pBU\"\0005�� i�ׂ��C�p�\n�i@�[��4�jЁ�6b�P�\0�&F2~������U&�}����ɘ	��Da<��zx�k���=���r3��(l_���FeF���4�1�K	\\ӎld�	�1�H\r���p!�%bG�Xf��'\0���	'6��ps_��\$?0\0�~p(�H\n�1�W:9�͢��`��:h�B��g�B�k��p�Ɓ�t��EBI@<�%����` �y�d\\Y@D�P?�|+!��W��.:�Le�v,�>q�A���:���bY�@8�d>r/)�B�4���(���`|�:t�!����?<�@���/��S��P\0��>\\�� |�3�:V�uw���x�(����4��ZjD^���L�'���C[�'�����jº[�E�� u�{KZ[s���6��S1��z%1�c��B4�B\n3M`0�;����3�.�&?��!YA�I,)��l�W['��ITj���>F���S���BбP�ca�ǌu�N����H�	LS��0��Y`���\"il�\r�B���/����%P���N�G��0J�X\n?a�!�3@M�F&ó����,�\"���lb�:KJ\r�`k_�b��A��į��1�I,�����;B,�:���Y%�J���#v��'�{������	wx:\ni����}c��eN���`!w��\0�BRU#�S�!�<`��&v�<�&�qO�+Σ�sfL9�Q�Bʇ����b��_+�*�Su>%0�����8@l�?�L1po.�C&��ɠB��qh�����z\0�`1�_9�\"���!�\$���~~-�.�*3r?�ò�d�s\0����>z\n�\0�0�1�~���J����|Sޜ��k7g�\0��KԠd��a��Pg�%�w�D��zm�����)����j�����`k���Q�^��1���+��>/wb�GwOk���_�'��-CJ��7&����E�\0L\r>�!�q́���7����o��`9O`�����+!}�P~E�N�c��Q�)��#��#�����������J��z_u{��K%�\0=��O�X�߶C�>\n���|w�?�F�����a�ϩU����b	N�Y��h����/��)�G��2���K|�y/�\0��Z�{��P�YG�;�?Z}T!�0��=mN����f�\"%4�a�\"!�ޟ����\0���}��[��ܾ��bU}�ڕm��2�����/t���%#�.�ؖ��se�B�p&}[˟��7�<a�K���8��P\0��g��?��,�\0�߈r,�>���W����/��[�q��k~�CӋ4��G��:��X��G�r\0������L%VFLUc��䑢��H�ybP��'#��	\0п���`9�9�~���_��0q�5K-�E0�b�ϭ�����t`lm����b��Ƙ; ,=��'S�.b��S���Cc����ʍAR,����X�@�'��8Z0�&�Xnc<<ȣ�3\0(�+*�3��@&\r�+�@h, ��\$O���\0Œ��t+>����b��ʰ�\r�><]#�%�;N�s�Ŏ����*��c�0-@��L� >�Y�p#�-�f0��ʱa�,>��`����P�:9��o���ov�R)e\0ڢ\\����\nr{îX����:A*��.�D��7�����#,�N�\r�E���hQK2�ݩ��z�>P@���	T<��=�:���X�GJ<�GAf�&�A^p�`���{��0`�:���);U !�e\0����c�p\r�����:(��@�%2	S�\$Y��3�hC��:O�#��L��/����k,��K�oo7�BD0{���j��j&X2��{�}�R�x��v���أ�9A����0�;0�����-�5��/�<�� �N�8E����	+�Ѕ�Pd��;���*n��&�8/jX�\r��>	PϐW>K��O��V�/��U\n<��\0�\nI�k@��㦃[��Ϧ²�#�?���%���.\0001\0��k�`1T� ����ɐl�������p���������< .�>��5��\0��	O�>k@Bn��<\"i%�>��z��������3�P�!�\r�\"��\r �>�ad���U?�ǔ3P��j3�䰑>;���>�t6�2�[��޾M\r�>��\0��P���B�Oe*R�n���y;� 8\0���o�0���i���3ʀ2@����?x�[����L�a����w\ns����A��x\r[�a�6�clc=�ʼX0�z/>+����W[�o2���)e�2�HQP�DY�zG4#YD����p)	�H�p���&�4*@�/:�	�T�	���aH5���h.�A>��`;.���Y��a	���t/ =3��BnhD?(\n�!�B�s�\0��D�&D�J��)\0�j�Q�y��hDh(�K�/!�>�h,=�����tJ�+�S��,\"M�Ŀ�N�1�[;�Т��+��#<��I�Zğ�P�)��LJ�D��P1\$����Q�>dO��v�#�/mh8881N:��Z0Z���T �B�C�q3%��@�\0��\"�XD	�3\0�!\\�8#�h�v�ib��T�!d�����V\\2��S��Œ\nA+ͽp�x�iD(�(�<*��+��E��T���B�S�CȿT���� e�A�\"�|�u�v8�T\0002�@8D^oo�����|�N������J8[��3����J�z׳WL\0�\0��Ȇ8�:y,�6&@�� �E�ʯݑh;�!f��.B�;:���[Z3������n���ȑ��A���qP4,��Xc8^��`׃��l.����S�hޔ���O+�%P#Ρ\n?��IB��eˑ�O\\]��6�#��۽؁(!c)�N����?E��B##D �Ddo��P�A�\0�:�n�Ɵ�`  ��Q��>!\r6�\0��V%cb�HF�)�m&\0B�2I�5��#]���D>��3<\n:ML��9C���0��\0���(ᏩH\n����M�\"GR\n@���`[���\ni*\0��)������u�)��Hp\0�N�	�\"��N:9q�.\r!���J��{,�'����4�B���lq���Xc��4��N1ɨ5�Wm��3\n��F��`�'��Ҋx��&>z>N�\$4?����(\n쀨>�	�ϵP�!Cq͌��p�qGLqq�G�y�H.�^��\0z�\$�AT9Fs�Ѕ�D{�a��cc_�G�z�)� �}Q��h��HBָ�<�y!L����!\\�����'�H(��-�\"�in]Ğ���\\�!�`M�H,gȎ�*�Kf�*\0�>6���6��2�hJ�7�{nq�8����H�#c�H�#�\r�:��7�8�܀Z��ZrD��߲`rG\0�l\n�I��i\0<����\0Lg�~���E��\$��P�\$�@�PƼT03�HGH�l�Q%*\"N?�%��	��\n�CrW�C\$��p�%�uR`��%��R\$�<�`�Ifx���\$/\$�����\$���O�(���\0��\0�RY�*�/	�\rܜC9��&hh�=I�'\$�RRI�'\\�a=E����u·'̙wI�'T���������K9%�d����!��������j�����&���v̟�\\=<,�E��`�Y��\\����*b0>�r��,d�pd���0DD ̖`�,T �1�% P���/�\r�b�(���J����T0�``ƾ����J�t���ʟ((d�ʪ�h+ <Ɉ+H%i�����#�`� ���'��B>t��J�Z\\�`<J�+hR���8�hR�,J]g�I��0\n%J�*�Y���JwD��&ʖD�������R�K\"�1Q�� ��AJKC,�mV�������-���KI*�r��\0�L�\"�Kb(����J:qKr�d�ʟ-)��ˆ#Ը�޸[�A�@�.[�Ҩʼ�4���.�1�J�.̮�u#J���g\0��򑧣<�&���K�+�	M?�/d��%'/��2Y��>�\$��l�\0��+����}-t��ͅ*�R�\$ߔ��K�.����JH�ʉ�2\r��B���(P���6\"��nf�\0#Ї ��%\$��[�\n�no�LJ�����e'<����1K��y�Y1��s�0�&zLf#�Ƴ/%y-�ˣ3-��K��L�΁��0����[,��̵,������0���(�.D��@��2�L+.|�����2�(�L�*��S:\0�3����G3l��aːl�@L�3z4�ǽ%̒�L�3����!0�33=L�4|ȗ��+\"���4���7�,\$�SPM�\\��?J�Y�̡��+(�a=K��4���C̤<Ё�=\$�,��UJ]5h�W�&t�I%��5�ҳ\\M38g�́5H�N?W1H��^��Ը�Y͗ؠ�͏.�N3M�4Å�`��i/P�7�dM>�d�/�LR���=K�60>�I\0[��\0��\r2���Z@�1��2��7�9�FG+�Ҝ�\r)�hQtL}8\$�BeC#��r*H�۫�-�H�/���6��\$�RC9�ب!���7�k/P�0Xr5��3D���<T�Ԓq�K���n�H�<�F�:1SL�r�%(��u)�Xr�1��nJ�I��S�\$\$�.·9��IΟ�3 �L�l���Ι9��C�N�#ԡ�\$�/��s��9�@6�t���N�9���N�:����7�Ӭ�:D���M)<#���M}+�2�N��O&��JNy*���ٸ[;���O\"m����M�<c�´���8�K�,���N�=07s�JE=T��O<����J�=D��:�C<���ˉ=���K�ʻ̳�L3�����LTЀ3�S,�.���q-��s�7�>�?�7O;ܠ`�OA9���ϻ\$���O�;��`9�n�I�A�xp��E=O�<��5����2�O�?d�����`N�iO�>��3�P	?���O�m��S�M�ˬ��=�(�d�Aȭ9���\0�#��@��9D����&���?����i9�\n�/��A���ȭA��S�Po?kuN5�~4���6���=򖌓*@(�N\0\\۔dG��p#��>�0��\$2�4z )�`�W���+\0��80�菦������z\"T��0�:\0�\ne \$��rM�=�r\n�N�P�Cmt80�� #��J=�&��3\0*��B�6�\"������#��>�	�(Q\n���8�1C\rt2�EC�\n`(�x?j8N�\0��[��QN>���'\0�x	c���\n�3��Ch�`&\0���8�\0�\n���O`/����A`#��Xc���D �tR\n>���d�B�D�L��������Dt4���j�p�GAoQoG8,-s����K#�);�E5�TQ�G�4Ao\0�>�tM�D8yRG@'P�C�	�<P�C�\"�K\0��x��~\0�ei9���v))ѵGb6���H\r48�@�M�:��F�tQ�!H��{R} �URp���O\0�I�t8������[D4F�D�#��+D�'�M����>RgI���Q�J���U�)Em���TZ�E�'��iE����qFzA��>�)T�Q3H�#TL�qIjNT���&C��h�X\nT���K\0000�5���JH�\0�FE@'љFp�hS5F�\"�oѮ�e%aoS E)� ��DU��Q�Fm�ѣM��Ѳe(tn� �U1ܣ~>�\$��ǂ��(h�ǑG�y`�\0��	��G��3�5Sp(��P�G�\$��#��	���N�\n�V\$��]ԜP�=\"RӨ?Lzt��1L\$\0��G~��,�KN�=���GM����NS�)��O]:ԊS}�81�RGe@C�\0�OP�S�N�1��T!P�@��S����S�G`\n�:��P�j�7R� @3��\n� �������DӠ��L�����	��\0�Q5���CP��SMP�v4��?h	h�T�D0��֏��>&�ITx�O�?�@U��R8@%Ԗ��K���N�K��RyE�E#�� @����%L�Q�Q����?N5\0�R\0�ԁT�F�ԔR�S�!oTE�C(�����ĵ\0�?3i�SS@U�QeM��	K�\n4P�CeS��\0�NC�P��O�!�\"RT�����S�N���U5OU>UiI�PU#UnKP��UYT�*�C��U�/\0+���)��:ReA�\$\0���x��WD�3���`����U5�IHUY��:�P	�e\0�MJi�����Q�>�@�T�C{��u��?�^�v\0WR�]U}C��1-5+U�?�\r�W<�?5�JU-SX��L�� \\t�?�sM�b�ՃV܁t�T�>�MU+�	E�c���9Nm\rRǃC�8�S�X�'R��XjCI#G|�!Q�Gh�t�Q��� )<�Y�*��RmX0����M���OQ�Y�h���du���Z(�Ao#�NlyN�V�Z9I���M��V�ZuOՅT�T�EՇַS�e����\n�X��S�QER����[MF�V�O=/����>�gչT�V�oU�T�Z�N�*T\\*����S-p�S��V�q��M(�Q=\\�-UUUV�C���Z�\nu�V\$?M@U�WJ\r\rU��\\�'U�W]�W��W8�N�'#h=oC���F(��:9�Yu����V-U�9�]�C�:U�\\�\n�qW���(TT?5P�\$ R3�⺟C}`>\0�E]�#R��	��#R�)�W���:`#�G�)4�R��;��ViD%8�)Ǔ^�Q��#�h	�HX	��\$N�x��#i x�ԒXR��'�9`m\\���\nE��Q�`�bu@��N�dT�#YY����GV�]j5#?L�xt/#���#酽O�P��Q��6����^� �������M\\R5t�Ӛp�*��X�V\"W�D�	oRALm\rdG�N	����6�p\$�P废E5����Tx\n�+��C[��V�����8U�Du}ػF\$.��Q-;4Ȁ�NX\n�.X�b͐�\0�b�)�#�N�G4K��ZS�^״M�8��d�\"C��>��dHe\n�Y8���.� ���ҏF�D��W1cZ6��Q�KH�@*\0�^���\\Q�F�4U3Y|�=�Ӥ�E��ۤ�?-�47Y�Pm�hYw_\r�VeױM���ُe(0��F�\r�!�PUI�u�7Q�C�ю?0����gu\rqधY-Q�����=g\0�\0M#�U�S5Zt�֟ae^�\$>�ArV�_\r;t���HW�Z�@H��hzD��\0�S2J� HI�O�'ǁe�g�6�[�R�<�?� /��KM����\n>��H�Z!i����TX6���i�C !ӛg�� �G }Q6��4>�w�!ڙC}�VB�>�UQڑj�8c�U�T���'<�>����HC]�V��7jj3v���`0���23����x�@U�k�\n�:Si5��#Y�-w����M?c��MQ�GQ�уb`��\0�@��ҧ\0M��)ZrKX�֟�Wl������l�TM�D\r4�QsS�40�sQ́�mY�h�d��C`{�V�gE�\n��XkՁ�'��,4���^�6�#<4��NXnM):��OM_6d�������[\"KU�n��?l�x\0&\0�R56�T~>��ո?�Jn��� ��Z/i�6���glͦ�U��F}�.����JL�CTbM�4��cL�TjSD�}Jt���Z����:�L���d:�Ez�ʤ�>��V\$2>����[�p�6��R�9u�W.?�1��RHu���R�?58Ԯ��D��u���p�c�Z�?�r׻ Eaf��}5wY���ϒ���W�wT[Sp7'�_aEk�\"[/i��#�\$;m�fأWO����F�\r%\$�ju-t#<�!�\n:�KEA����]�\nU�Q�KE��#��X��5[�>�`/��D��֭VEp�)��I%�q���n�x):��le���[e�\\�eV[j�����7 -+��G�WEwt�WkE�~u�Q/m�#ԐW�`�yu�ǣD�A�'ױ\r��ՙO�D )ZM^��u-|v8]�g��h���L��W\0���6�X��=Y�d�Q�7ϓ��9����r <�֏�D��B`c�9���`�D�=wx�I%�,ᄬ�����j[њ����O��� ``��|�����������.�	AO���	��@�@ 0h2�\\�ЀM{e�9^>���@7\0��˂W���\$,��Ś�@؀����w^fm�,\0�yD,ם^X�.�ֆ�7����2��f;��6�\n����^�zC�קmz��n�^���&LFF�,��[��e��aXy9h�!:z�9c�Q9b� !���Gw_W�g�9���S+t���p�tɃ\nm+����_�	��\\���k5���]�4�_h�9 ��N����]%|��7�֜�];��|���X��9�|����G���[��\0�}U���MC�I:�qO�Vԃa\0\r�R�6π�\0�@H��P+r�S�W���p7�I~�p/��H�^������E�-%��̻�&.��+�Jђ;:���!���N�	�~����/�W��!�B�L+�\$��q�=��+�`/Ƅe�\\���x�pE�lpS�JS�ݢ��6��_�(ů���b\\O��&�\\�59�\0�9n���D�{�\$���K��v2	d]�v�C�����?�tf|W�:���p&��Ln��賞�{;���G�R9��T.y���I8���\rl� �	T��n�3���T.�9��3����Z�s����G����:	0���z��.�]��ģQ�?�gT�%��x�Ռ.����n<�-�8B˳,B��rgQ�����Ɏ`��2�:{�g��s��g�Z��� ׌<��w{���bU9�	`5`4�\0BxMp�8qnah�@ؼ�-�(�>S|0�����3�8h\0���C�zLQ�@�\n?��`A��>2��,���N�&��x�l8sah1�|�B�ɇD�xB�#V��V�׊`W�a'@���	X_?\n�  �_�. �P�r2�bUar�I�~��S���\0ׅ\"�2����>b;�vPh{[�7a`�\0�˲j�o�~���v��|fv�4[�\$��{�P\rv�BKGbp������O�5ݠ2\0j�لL���)�m��V�ejBB.'R{C��V'`؂ ��%�ǀ�\$�O��\0�`����4 �N�>;4���/�π��*��\\5���!��`X*�%��N�3S�AM���Ɣ,�1����\\��caϧ ��@��˃�B/����0`�v2��`hD�JO\$�@p!9�!�\n1�7pB,>8F4��f�π:��7���3��3����T8�=+~�n���\\�e�<br����Fز� ��C�N�:c�:�l�<\r��\\3�>���6�ONn��!;��@�tw�^F�L�;���,^a��\ra\"��ڮ'�:�v�Je4�א;��_d\r4\r�:����S�����2��[c��X�ʦPl�\$�ޣ�i�w�d#�B��b��������`:���~ <\0�2����R���P�\r�J8D�t@�E��\0\r͜6����7����Y���\"����\r�����3��.�+�z3�;_ʟvL����wJ�94�I�Ja,A����;�s?�N\nR��!��ݐ�Om�s�_��-zۭw���zܭ7���z���M����o����\0��a��ݹ4�8�Pf�Y�?��i��eB�S�1\0�jDTeK��UYS�?66R	�c�6Ry[c���5�]B͔�R�_eA)&�[凕XYRW�6VYaeU�fYe�w��U�b�w�E�ʆ;z�^W�9��ק�ݖ��\0<ޘ�e�9S���da�	�_-��L�8ǅ�Q��TH[!<p\0��Py5�|�#��P�	�9v��2�|Ǹ��fao��,j8�\$A@k����a���b�c��f4!4���cr,;�����b�=��;\0��ź���cd��X�b�x�a�Rx0A�h�+w�xN[��B��p���w�T�8T%��M�l2�������}��s.kY��0\$/�fU�=��s�gK���M� �?���`4c.��!�&�分g��f�/�f1�=��V AE<#̹�f\n�)���Np��`.\"\"�A�����q��X��٬:a�8��f��Vs�G��r�:�V��c�g�Vl��g=��`��W���y�gU��˙�Ẽ�eT=�����x 0� M�@����%κb���w��f��O�筘�*0���|t�%��P��p��gK���?p�@J�<Bٟ#�`1��9�2�g�!3~����nl��f��Vh���.����aC���?���-�1�68>A��a�\r��y�0��i�J�}�������z:\r�)�S���@��h@���Y���mCEg�cyφ��<���h@�@�zh<W��`��:zO���\r��W���V08�f7�(Gy���`St#��f�#����C(9���؀d���8T:���0�� q���79��phAg�6�.��7Fr�b� �j��A5��a1��h�ZCh:�%��gU��D9��Ɉ�׹��0~vTi;�VvS��w��\r΃?��f�����n�ϛiY��a��3�·9�,\n��r��,/,@.:�Y>&��F�)�����}�b���iO�i��:d�A�n��c=�L9O�h{�� 8hY.������������\r��և�����1Q�U	�C�h��e�O���+2o����N�����zp�(�]�h��Z|�O�c�zD���;�T\0j�\0�8#�>Ύ�=bZ8Fj���;�޺T酡w��)���N`���ÅB{��z\r�c���|dTG�i�/��!i��0���'`Z:�CH�(8�`V������\0�ꧩ��W��Ǫ��zgG������-[��	i��N\rq��n���o	ƥfEJ��apb��}6���=o���,t�Y+��EC\r�Px4=����@���.��F��[�zq���X6:FG��#��\$@&�ab��hE:����`�S�1�1g1���2uhY��_:Bߡdc�*���\0�ƗFYF�:���n���=ۨH*Z�Mhk�/�냡�zٹ]��h@����1\0��ZK�������^+�,vf�s��>���O�|���s�\0֜5�X��ѯF��n�A�r]|�Ii4�� ��C� h@ع����cߥ�6smO������gX�V2�6g?~��Y�Ѱ�s�cl \\R�\0��c��A+�1������\n(����^368cz:=z��(�� ;裨�s�F�@`;�,>yT��&��d�Lן��%��-�CHL8\r��b�����Mj]4�Ym9����Z�B��P}<���X���̥�+g�^�M� + B_Fd�X���l�w�~�\r⽋�\":��qA1X������3�ΓE�h�4�ZZ��&����1~!N�f��o���\nMe�଄��XI΄�G@V*X��;�Y5{V�\n���T�z\rF�3}m��p1�[�>�t�e�w����@V�z#��2��	i���{�9��p̝�gh���+[elU���A�ٶӼi1�!��omm�*K���}��!�Ƴ��{me�f`��m��C�z=�n�:}g� T�mLu1F��}=8�Z���O��mFFMf��OO����������/����ޓ���V�oqj���n!+����Z��I�.�9!nG�\\��3a�~�O+��::�K@�\n�@���Hph��\\B��dm�fvC���P�\" ��.nW&��n��HY�+\r���z�i>Mfqۤ��Qc�[�H+��o��*�1'��#āEw�D_X�)>�s��-~\rT=�������- �y�m����{�h��j�M�)�^����'@V�+i�������;F��D[�b!����B	��:MP���ۭoC�vAE?�C�IiY��#�p�P\$k�J�q�.�07���x�l�sC|���bo�2�X�>M�\rl&��:2�~��cQ����o��d�-��U�Ro�Y�nM;�n�#��\0�P�f��Po׿(C�v<���[�o۸����fѿ���;�ẖ�[�Y�.o�Up���pU���.���B!'\0���<T�:1�������<���n��F���I�ǔ��V0�ǁRO8�w��,aF��ɥ�[�Ο��YO����/\0��ox���Q�?��:ً���`h@:�����/M�m�x:۰c1������v�;���^���@��@�����\n{�����;���B��8�� g坒�\\*g�yC)��E�^�O�h	���A�u>���@�D��Y�����`o�<>��p���ķ�q,Y1Q��߸��/qg�\0+\0���D���?�� ����k:�\$����ץ6~I��=@���!��v�zO񁚲�+���9�i����a������g������?��0Gn�q�]{Ҹ,F���O���� <_>f+��,��	���&�����·�y�ǩO�:�U¯�L�\n�úI:2��-;_Ģ�|%�崿!��f�\$���Xr\"Kni����\$8#�g�t-��r@L�圏�@S�<�rN\n�D/rLdQk࣓�����e����Э��\n=4)�B���ך��Z-|Hb����Hk�*	�Q!�'��G ��Ybt!��(n,�P�Ofq�+X�Y����\"b F6��r f�\"�ܳ!N��^��r�B_(�\"�K�_-<��*Q���/,)�H\0����r�\"z2(�tه.F>��#3���268sh٠��ƑI1Sn20���-��4���2A�s(�4�˶��\0��#��r�K'�ͷG'�7&\n>x���J�GO8,�0���8���\0�W9��I�?:3n�\r-w:�����;3ȉ�!�;��ꃘ�Z�RM�+>�����0/=R�'1�4�8����m�%ȥ}χ9�;�=�nQ��=�hhL��G�kW�\r�	%�4Ҝs�ΖJ�3s�4�@�U�%\$���N;�?4���N��2|��Z�3�h\0�3�5�^�xi2d\r|�M�ʣbh|�#v�` \0�ꐮ���\$\r2h#���?���I\n���+o-��?6`ṽ�.\$���KY%�J?�c�R�N#K:�K�EL�>:��@��jP��n_t&slm�'�ЩɸӜ�����;6ۗHU5#�Q7U��WY�U bN��W�_���;TC�[�<ږ>����W�CU��6X#`MI:t�ӵ��	u#`�fu�\$�t���X�`�f<�;b�gh���9�7�S58���#^�-�\0����չR*�'��(���qZ壣�X�Q�FUv�W GW���T��W�~ڭ^�W�����J=_ؗbm��bV\\l��/�M��TmTOXu�=_��ITvvu�a\rL_�qR/]]m�su=H=u�g o\\UՅgM�	XVU��%�h��53U�\\=��Q��M�v���g�m��ue�����h�b�M�GCeO5�ԁ�O5��Y�i=e�	G�TURvOa�*�ivWX�J5<��bu�]������<����\$u3v#�'e�u�R5m��v�D5�.v���W=�U_�(�\\V��_<��S�n)�1M%Qh�Z�T�f5E�'��W��v�UmiՂU��]aW�U�dRv��-YUZu��UV��UiR�V������[��ZMU�\\=�v{�X���wQ�huHv��gqݴw!�oqt�U{TGq�{�#^G_ubQ���i9Qb>�NUd��k��5hP�mu[�\0����_��[�Y-����r���(�CrMe�J�!h?QrX3 x���#��x�<�{u5~���-�u��YyQ\r-��\0�uգuuٿpUڅ�)�P��\r<u�S�0��w��-i���!�֊�B���d]��Ň��E��vlmQݏ6k��J��w�Ğ����ED�U�R�e�v:X�c�NW}`-�t�H#e��b��u���	~B7� ?�	OP�CW���SE͕V>���U�7�����m�ӂ�z�=����1���+��m�I,>�X7��]�.��*	^��N��.��/\"���)�	���s��|��ӟ�l�}�����!�5n�p�j��h�}���m�E�zH�aO0d=A|w�߳������u���v���G�x#��b�cS�o-��tOm`C��^M��@�h�n\$k�`�`HD^�PE�[�]��rR�m�=�.�ه>Ayi� \"���	��o�-,.�\nq+���fXd����*߽�K�؃'�� �%a����9p���KLM��!�,������zX#�V�uH%!��63�J�ryՁ��q_�u	�W����|@3b1��7|~wﱳ��A7���	��9cS&{���%Vx��kZO��w�Ur?����N �|�C�#Ű��կ �/��9�ft�Ew�C��a�^\0�O<�W�{Y�=�e��n���gyf0h@�S�\0:C���^��VgpE9:85�3�ާ���@��j_�[�+��ǩx�^�ꮆ~@чW���㓜�9x�FC���.�����k^I���pU9��S������\$���\r4���\0��O���)L[�p?�.PECS�I1nm{�?�P�WA߲�;���D�;S�a�Kf��%�?�X��+��B>��9���Gj�c�z�A͎�:�a�n0bJ{o��!3��!'��K�����}�\\��3W��5�x���L;�2ζn�a;���׺Xӛ]�o��x�{�5ޙjX���vӚ��q��EE{р4����{���	�\n��>��aﯷ�����L����������'����{�\n��>J�ߌ��ӗ��Y�\rOʽ�t����-O���4��9F�;�����G��I�F��1�o����O���a{w�0����Ư;񔄑l�o��J�Tb\rw�2�J��=D#�n�:�y��S�^�,.�?(�I\$���Ư��3��s�4M�aCR���G̑��I߰n<�zy�XN��?��.��=���DǼ�\r����\n��\ro��\nПCl%��Y���߰��G���}#�VН%�(����3�ɍ�r��};��׿G��n�[�{����_<m4[	I����q��?�0cV�nms��nM���\"Nj1�w?@�\$1��>��^�����\\�{n�\\���7���ٟic1���hoo�?j<G�x�l���S�r}���|\"}��/�?s��tI���&^�1e��t��,�*'F��=�/F�k�,95rV������쑈��o9��/F��_�~*^��{�I����_�����^n���N��~���A�d����U�w�qY���T�2��G�?�&����:y��%��X�J�C�d	W�ߎ~�G!��J}��������B-��;���h�*�R���E��~���.�~���SAqDVx���='��E�(^���~����������o7~�M[��Q��(��y��nP�>[WX{q�aϤ���.&N�3]��HY������[���&�8?�3������݆����#���B�e�6��@��[������G\r�+��}������_��7�|N����4~(z�~����%��?����[��1�S�]x�k��KxO^�A���rZ+����*�W��k�wD(���R:��\0����'����m!O�\n��u���.�[ �P�!��}��m ��1p�u��,T��L 	0}��&P٥\n�=D�=���\rA/�o@��2�t�6�DK��\0���q�7�l���B���(�;[��kr\r�;#���lŔ\r�<}zb+��O�[�WrX�`�Z ţ�Pm'Fn����Sp�-�\0005�`d���P���Ǿ��;��n\0�5f�P���EJ�w�� �.?�;��N�ޥ,;Ʀ�-[7��e��i��-���dَ<[~�6k:&�.7�]�\0������/�59 ��@eT:煘�3�d�sݝ�5䏜5f\0�P��HB�����8J�LS\0vI\0���7Dm��a�3e��?B��\$�.E���f���@�n���b�Gb��q3�|��Paˈ�ϯX7Tg>�.�p�5��AHŵ��3S�,��@�#&w��3��m[���I�ѥ�^�̤J1?�gTၽ#�S�=_��_��	���Vq/C۾�݀�|�����D �g>܄��� 6\r�7}q��Ť�JG�B^�\\g������&%��[�2Ixì��6\03]�3�{�@RU��M��v<�1����sz�uP�5��F:�i�|�`�q���V| ��\nk��}�'|�gd�!�8� <,�P7�m��||���I�A��]BB �F�0X���	�D��`W���qm�OL�	�.�(�p��ҁ��\"!����\0��A����V��7k��M�\$�N0\\���\"�f������\0uq��,��5��A6�p���\n�ΐjY�7[pK��4;�l�5n��@�\\f��l	��M���P��3��C�HbЌ��cEpP���4eooe�{\r-��2.�֥��P50u���G}��\0����<\r��!��~�������\n7F��d�����>��a��%�c6Ԟ��M��|��d����O�_�?J��C0�>Ё�&7kM4�`%f�l�ΘB~�wx��ZG�P�2��0�=�*p��@�BeȔ��|2�\r�?q��8����Њ(�yr���0��>�>�E?w�|r]�%Av�����@�+�X��Ag����s��C��AXmNҝ�4\0\r���8J�J�ǸD�Қ�:=	������S�4��F;	�\\&��P!6%\$i�xi4c�0B�;62=��1��̈PC��m���dpc+�5��\$/rCR�`�MQ�6(\\��2A���\\��lG�l�\0Bq��P�r���B����т�_6Ll�!BQ��IG�����XRbs�]B�Hr���`�X��\$p�8���	nbR,±�L��\"�E%\0�aYB�s���D,�!��ϛpN9RbG�4��M��t����jU�����y\0��%\$.�iL!x��ғ�(�.�)6T(�I��a%�K�]m�t���&��G7�ITM�B�\rza��])va�%���41T�j͹(!�����\\�\\�W��\\t\$�0��%�\0aK\$�T�F(Y�C@��H���H�nD�d��Wp��hZ�'�ZC,/���\$����J�FB�uܬQ:Υ�A��:-a#��=jb��l�Ug;{R��U��EWn�Ua��V��Nj��u�G�*�yֹ%��@��*���Yx�_�z�]�)v\"��R��L�VIv�=`��'��U�) S\r~R���\ni��)5S��D49~�b�;)3�,�9M3�HsJkT�Ü�(����uJ�][\$uf��ob���\n.,�Yܵ9j1'��!�1�\$J��gڤ՟ĆU0��Zuah���cH��,�Yt��Kb�5��5��/dY��AU�҅��[W>�_V�\r��*���j��-T�� z�Y�d�c�m�ҹ��:����[Ut-{���l	�i+a)�.[��_:�5��h��W§�m��%JI��[T�h>�������;�X̺d�S�d�V�;\rƱ!N��K&�A�Ju4B��dg΢.Vp��mb��)�V!U\0G丨��`���\\��q�7Q�b�VL��:�Ղ���Z.�N��*�ԏU]Z�l�z������R D1I��£�r:\0<1~;#�Jb���M�y�+�۔/�\"ϛj<3�#��̌��:P.}�e����D\"q�yJ�G���sop�����X�\r��d��\rxJ%���ƼO:%yy��,��%{�3<�Xø����z�E�z(\0 �D_���.2+�g�b�c�x�pgި��|9CP����48U	Q�/Aq��Q�(4 7e\$D��v:�V�b��N4[��iv���2�\r�X1��AJ(<PlF�\0���\\z�)���W�(�4����� p�����`��\r�da6����O��m�a�}q�`��6P�'h��3�|����f� j��A�z���+�D�UW�D���5��%#�x�3{��L\r-͙]:jd�P	j�f�q:Z�\"sad�)�G�3	��+��r�NK��1Q���x=>�\"��-�:�F���Iك*�@ԟ�y�T�\\U��Y~������3D������f,s�8HV�'�t9v(:��B9�\\Z����(�&�E8���W\$X\0�\n��9�WB��b��66j9� �ʈ��?,��| �a��g1�\nPs�\0@�%#K����\r\0ŧ\0���0�?�š,�\0��h��h�\08\0l\0�-�Z��jb�Ŭ\0p\0�-�f`ql��0\0i-�\\ps��7�e\"-Z�lb�E�,�\0��]P ��E��b\0�/,Z��\r�\0000�[f-@\rӯEڋ�/�Z8��~\"��ڋ��.^��Qw��ϋ�\0�/t_ȼ���E���\0�0d]��b�Ť�|\0��\\ؼ���E�\0af0tZ��n�J�\0l\0�0L^��Qj@��J��^��q#F(�1�/�[�1�����I�.�^8��\0[�q��[Ñl\"�� ��\0�0,d����\r����c��{cE�\0o�0�]�\0\rc%�ۋ���8�w���Z��-�\\��{��֋G�/\\bp��@1�\0a�1�����s�!Ũ�/�/�]8��~c\"�ۋ��2�cΑm�\"�9�q�/\\^fQ~c�_���-\$i�\"�\0003����fX�qx#\09��Z.�i���@F���3tZH� \rcK�b\0j�/Dj��1����I�h�a��v�Ʃ�OZ4�Z��т#YE�\0i�.hH��sX/F<���.�j���b���\0mV/d\\���b�E����3T^(�шcKFR�����]X�q��������6�]h��c6Eċ�66�h����n\0005�sn/dn��`\r\"�F���-D`�Ց��N�2�Y��bx��#\\�닇V3x�1x�Fx��\0�6�b�q����!��8|^���ub�����-�r��q��:��%�0�pp�#����\0�6�f��Ǣ�Ŭ�d�0�qH����\$�@�q�-�^B4��\"�\08�1�/lnxϑ���G�3:0tjh�~@Ƽ���3�vH��b�G(�e��4gغq��2�1��-�nX��\"�F<�Q�1\\j��1���Eǋ��4m����[�n�z7�yh�1�#�ގ/�3\\x�q�KG����6�o��1{��FJ���6�lX�q⣄�u���9�r(�1��Gc\0�f:�rX��#�Ž\0i�<\\}���b�F�\0s�7�y2���#uFe��\">4i��������\n<{�㑍��Ɖ�J;�]��1�#��0��J;4^��D���Ǯ����4i��(H#��E�x�/�n��1��/ǡ��j6,l��1t�/\0005%�0�]x����GG5�!�0��������r�q�2��ޑ��NFP�o\"4�_��1�d�%�e �3�s8���G5�� �6�[H��c�H�jY�;�[辑�b�! �y�@�\\��q�#WHN���;�c�Q��:�-�%�.�kXƑ���G͌��1Df�ߑ�cWFl��!�0����c Eܐ��;l��q�\"�F����7\\\\������O�q�.T|\"?����E��f9TyYѩ�SG1���A\$f9R\n\"��x��>B��H��ߤ\0���:\$e�1���F?�=�3Tu)\nq�b��~���<T��α�c�H.�m~C�wHʱ�#/�I�]~3�^��ф#��>�Y�4�^��Qjc��K�1\"�8�|6��c\"�B��\"b4���%����G\0e\"�/t���1r�1��e!v2�y����<Ǡ���8\\o��ђ#t�ѐ\rz@�}H�b���y �1�\\���deG��Z3�~�r)�1ȿ���Bl~H��:�dF��-�?�k8�q�c(F͋�K�5|my�c1�<�*@�j���1��ž��>I�Z��Qj��2��\$0��h�Q��VFT�	\$�Al~�qڣȱ�\$�>\\p�\rq�\$/�u%�!�Jq \$��tE��GN-Tq)�\"��Hʌ��=�X�2-�H���8\\n��RW\$H��\"�C\\_�\0�d\$�f��\".D�u	'Q�zE��&0to��qj��ƿ��R@d������u�##�LLk�*q�\$*Gđi�@T�i�l��E����5���r\\d�I���\"/�Z�0�j\$T���z5Ld3�����o�.Tq�!1{�����9�Z��Q�b�F�wJ94n�����{�(�-�8�2h�u��;\$�-Dk��rs��H���#���Y7�\"�/E����	\$j�^�-�]�7�[\"N\$����W����/]�\$�+�1Ga�/&IDn�@\$��!��\$�-�k!�Q����)(N/\$t������O�KzP�tX��[\0�G��w(*K\$v��1�c�'��G̞I�xd��\n�A�8\\rX��a��I�iN�I%\$���_���6�f�Q�#��I�5#�F��غ��#�E⒕\"�3\$�I�c�H���vR|�Q��cE���:R�e��h�EΏfK`8�r.#�E��s�0L���R��F���!\nC\$`���\$�H?��nP�e�!�@F'���/�����������%�N,h��rF\$�����3�t��Ҁ���!1<��CQ�%�Ò��J�Z�f.�6ō����C���Ԝ.�[��Bҿx����\0NRn`���Y\n�%+N�IMs:ùYd�ef�B[���nƹY��m��R�ג��Y��C�X���j��U+Vk,�\0P��b@e���x��V��yT�7�u�[J�ȱ\nD��eR��mx&�l�\0)�}�J�,\0�I�ZƵ\$k!���Yb�����Re/Q���k�5.�e��5����W�`��\0)�Yv\"V�\0��\n�%��`Yn�աa��xÆQ!,�`\"�	_.�偩Ɩtm\$�\"��J��֍���v�%�M9j��	斧�*�Kp֔�;\\R ��3(���^��:}���|>µa-'U%w*�#>�@�̬e�J���;Pw/+��5E\rjn���d���^[���cΰ�u�z\\ؐ1mi\"x��p��;����P)����#��ؒ���!A�;��	4�a{`aV{K�U��8㨟0''o�2���yc̸9]K�@�җ^�lB��Or���,du��8�?����%�gB����Yn+�%c�e\0���ऱYr@f�(]ּ�\nbiz��n�SS2��GdBPj���@�(�ȥ�!�-�v��e�*c\0��4J�炒���,�U�	d��e�j'T�H]Ԋ�G!�)u��֯��ү�Z�B5�̓W��0\n���R���W��\\�Q j�^r�%l��3,�Yy��f3&��܎�Q:ϵ2�m�R)�T��(KR��0�ʔ@��Y��Y:��e3\r%���T�%�X����ST�.J\\�0�h�ą�D!�:�u���U\"�Ł�o+7�\"����f'��R\0���J��2S�2�#nm ��I劜�\"X���[�ր��} J��c�9p0���Q�(U\0�xDEW��.L��=<B�0+�)ZS V;�\\�I{�5I�A���,dW�u�5Ew\n\$%ҁ���2i_\$��+��O,����X��ՑJg&J��G��%\\J��b.��^L�T�Fl�薹]k#f@L�G�ĐT�ٗ��H��\"�q1S̰��j�V�(Ι��ZVz�ņ�,����G�.1F��gN�;�1ÊV��5E��5`�\0Ct�=F\nṛα�K����\0�ۊ�%��D]Q\$\r\0�3J\\,͙��<T4*���.�YK�D�Q��L�S%,�g������<��u0���Uĉ�*x(��NYv!��y�	w�4fd��rG��M \$��^;�����)<P�]D�%%�;�j��I0�a�u^Jp�[)�v�3RhR�E��\n�L_�#5|ܾ�m3P�*�\\Y51X��	i�N���\$\"��a���h*KU���V8��u�%&�r�˚��5o���g�;�rMl[ƨ�g������U�q�깚h|�eO2�f MlW2AP�׹�����v~eD�e�3Uӫl�E62i�����Ub���U���������V��iI!\$i�ʭ&Z:��xm!ņ�.�O�fwү!���kݤ̓��6b\"�I�J]]:T��6�Vr��}��ǫ]����U��	ys7f�Mř�3����Y��:T_M�w%3�n��\n��z*��3�h��	�`U��L���,�ۄ�5��vf��Û�42_Q��h���uD�\no��)�ĜիM9�7foۼ��r����WB~iT�eyQT�N\n�d�pr�#��M�;���4�p���t���(;���5	|��ǂ��',AV7ܔ��UA�&��R�P�\"��y�ҷ��)�[�n���-3V��,?�s6�p���3�f��A��9k|�ɮS�f�*@��5�g��ɿ2��}����U�ݙ����H�F�l%�p«Ie�be�M�SO\r�[��i�3�f��LV��r�u�����NA�:�%r��y3Q�_̸�W.���^Sl@&���5�Yl��1���}Vx�gʅ�^Sn���Q!:5�Z�iZCԈ:���3qg�%D��ݪ{U�3�tZ�`��u%w:�ZQ:Q���W f�훿9Jpl�)�3x�v���K7�b#�����X+J�(��h��P*Ӂ���Λ��!ה�ŏSL�h*'���\npB��ڪ�gNʝ�8BuҪ���Ό��8ni�I�s�US�I��;vvڳU�sR�7N�u�8�H|���ӷ�̎��8�q����+'���`�x�9R�	ծ��MaR8�x�)��'!���;�U��Y֓��sNI�g:�KT�y�3�g��Y����k���ܳn'LO(��3�w4�4������l���J����w��9�\\����hf(�_~���}9N���\0���b\"�Y餃Th,ڞ�@��D���\$�I��;�e��U��n����,�O��	X��g�-���+>ti'G����l�%\0�8�VB�U1�ye�\0KT�4���m��V2)\r]I/\rF���X���ߨ�a��G�¹�*�����>ER������Z�-)I\$����:�a�\0�Fyba�g�w��(�_@�v}�i�ʳ�S^�25DԳ�	��URO��JH��\\�is�f��K�N��qi�Sg�O\n�F~|���*@gR�_Q<9sܬ3i+ؗ�.Cw���|���y�6a�O�Y9���ɖ\n�Խ-([���_�}�S�]c�S=��������Y��U->�<���\n<�sO�Q4F�^}\0007u�k(/���/5{L�9�\0����&��[<���s�\0&��#�@h��3�V}��H���*�w+]'D�&�@�ց])��;TGe3��\\��n����d\$:�uN4�ykt�-dR!7����e4(P!��-��9�4�_PMGb��ıw����6O�S�F���)��yh0+����qT|��+u���+��A�?��	�T�3.q��41T��e��\n:P����{T�\n��h?��T�A�S��*���+�u�>�\\�Z����Y췢wEJ��%��s�L��d��y�+\rC�ߡ'A�l,�y�3���͗`�	_*�P� ThKDV���~5	�0�+�,�-?�]���3�֍K�`�^���I42(]�w�.�r����]�\nYƨB����	��}ЋR ��g�}:H��J�WP��\"޵���V\\�<��? >�����ܬ݆�=��:�\n0��\\+�S���f�U���U,�WCֈ�On��΅��.�e9|R�I'�[�/������2���Q��Bn:�I�\n��g�9�\r�,�R6����Q\$X�+�>����`\n�)/_8Qi�����=��v?5v�\0 \n���LG�Dm�w\\�F֌�Ѣ���dꟵ}s�\"��Yv�|�J*�9h���@XEU�*�(oQ]\$�B��,�����KT�v�AptCɃ\n�C,/�<��ڙEW�-V�P��=W�*%K�-Q`9	(��59Ӏ�m)�X��@�2���T@��\nS���bd�Eδa�+�DX��|U�	�	��F� 2�%5\nj�m��W�+�x�K��V�3#��CT�ek���&�,�l�jbd7)ӓ\"\n+�P��b��I�@�3��ܵjU��Es��)D�f뒃������P�Z3AΌ�\nwTh𗲪ۘ�4Z��<�uߩ�dq�ˊu(���bKG����n�Tﮈ]z��f%#�3I�fS��&}�@D�@++��A�h���\n��U�ޥ|B�;��Um��U�E�N�!�x2�1�\0�GmvH~��H�T�)�W��YN�\"�k5��vT#=�ڥ�<\n}�#R3Y�H�R�Iͳܦ;��Rl�1l�uB%TQJ�*���'�E�0i�dw,�z�ͥ:\$��;�?���j��)��)ԏ�\$32J}�&�[�\$��́�;Dn��E״�+0�aZ{���C ���(��:����O@h��D��\0��`PTou����F�\rQv����o�ܡ\$S��+��#7��Izr�pk�DW��Fs�9��Q� ���1�g��#�\0\\L�\$��3�g�X�y�y �-3h����!�nX��]+��	ɝ�c\0�\0�b��\0\r���-{�\0�Q(�Q�\$s�0���m(�[Ru�V����>��+�J[�6����J\0֗�\\���,��K�3�.�]a_\0R�J Ɨ`�^ԶClR�IK��\n�\$�nŏ���Kj��\n����~/��mn�].�`��ij��#K��f:`\0�錀6�7K▨zc��\0����/K���/�d���FE\0aL���dZ`�J�S��ʙ�2��4�@/�(��L��0�`�ĩ��_�L��]4Zh�Щ�SD�M��4:c��SR��M�E4�i��SG�EMj��4zd�թ�SFKL��%4�e��%\$�lKM2��1�ڔ�i����MV��.�ڔ�i����Lz�/���ۣӄ��M�,`�_��imS��gMƜ�jg�����5�9.��9j_��S���.��9�_���S���.�7�r�)��%�[2�m8�uT��S��3M:�]3�q���nӱ�KN�1|^�kt�\"��H�gKj�-;zc�i�Ӛ����\r<�_�-i�Ӹ��\"֞U.���i�RڑkOF��=:\\��\$Zө�MLE�5�x����ӻ_\"֜=<\0�t��S�9OҞ�1�~��i�����O��>�~q�)�F����=6:~���J���P:��=��T�)�ƫ��PJ8�@�w�����*��O�5]>��t���T\n��!\"��6Y	)��H�/P���3�	���/��P~���	�Ӯ�!\"��C����j� �eNJ������*%�4�1Q��CZ�Q�jTB�Q.�\rE)\0004��\$�2�SM+�<j�t�j0�,�9Q��}F\0\$�s��Ta��KΣ]Ecj*�'K�M��MGx��R�T1�#QꡥG��5�:�z�L��4u6z��\"j\"T�KuN֣�G�g\$jFSܨ�Q2��H��\"�MT��%R��Hz��\$�,�w�Re.\$r�z�)��Ԧ�-Q���J���ʪ@԰�=R&/�Iʕ1�*]T���7���Q��D&өqN�_(�q�c[Tw�QR�崜J�\0n��T���.��956c�܌�Sz�H���7�R�}�Sr8�N���\"b�T��Q�5MN���#����ES§-H��7\"�T��_S�}G�̕?*yԩ��S�P*�5#���܍�T:�]Pʟ�C*�ԉ�T:�-K8�5C����R�--MȾ�H��� �'T���H���H���ы�T���R���,���܋GTک-SJ��M*�ԩ�UTکmMH��M���>�gSD�5M�R���H�wU\"��K8��R���ڌ�U*�-U*��n¾T�IR�,t�Z���Y�IUF�51���W)v�k�_KƫpJ�5Zj�ů�R�4r\n�^jI�CK����}Uʓ_��ԛ��O�=N�R*�F-��R��%W���c��\\�aV>�EYj��d���ëUά�WX�5*�Ջ��Uy��Z��1k�ը�7V��R\\H�5h*�U���UƧM[���k�vո�3V�}[(�5W�zո�iB�O��1��T���V�;�[��pR�Gu�;T@0>\0��/I���W`�]��\0���8��P��]��1m*��ǍyUz�mW��|�ݓ[��֯�]J�ш��U������Z*�5\\j����Z��`Z�5~��E�W��4Z��5h�Q�^�cXZ��S��1o�V��U&��T��5}cU^��X��dm*���kUu��SfG=[��j�sտ��X�Kc\n�iR�H�i#��uWt��������X�cĹ��U���rڢ�UZ�Շ�NE���X���4��ud�E�eV^��K��n��V8�sX¥�f��/�hJ�-J]ӂ������zO��<Eh�\$勓���\0K��<bw��>���N�\")]b�	�+z�.cS.�iF�	���QNQ���V*������O[X�nx��P	k��oN��}<aO�Iߓ�h���T;�r񉉤�VD6Q�;z�]j�~'�:�[Iv��7^ʑ����j�w[������ņ�:u �Ds#���\\w�<n|*�h�m�Kv;Y҈��3�]��^#�Z�j�gy�jħY,�%;3������.�W\"��\$�3>gڜ���Ϧ�V�T�Zj�hY�j�kD*!�h&Xz�i���+GV��\"��Z�:Ҥ�+�NoG�Zjj�i�]ʞkO�_�֬ԐmjI����t��#�[�j\rn�����n��Z�_,���g�Ě�:���9����[L2�W=T��0��f�\0P�U6\ns%7isY�?��u�3���nb5�����X|G~l�&�k���M��������y�S��)�]�ܭr��ٸ�������?�}u'n0W-ι��b��Ǫ���k?�vQ�7��}p\n�����ٮZ*�9)��5ޕZW�-ZB���:��㫊W�\0WZfp�Gp���ٮ:�Fp����U��SN/��\\��%s9�S{� �8��Z�as�ۓ�+�N^��9�M�{�P5�� �Q���J���y����;����z����Y�V �3�:�D�I���+����19M;�������V���\rQ{��ծ���+��F�CLĹ�N���Ԉ�\\��)\$i���N'\0���P����]X�^�s1�f�&�\"'<O���̡�L\0�\"�@���%�6��UA�1�i(z��݁�\r�Ղ��bZ��+IQO�3���\r=*ĉ��)�!����`��h��,ЫmGPC��A��ٲ�A��(ZŰ%�t�,h/���i��k���XEJ6�ID�Ȭ\"�\n�aU- ��\nv�y��_���ګ�k	a�B<�V�D�/P���a��)9L�(Z��8�vvù�k	�o�ZXk���|�&�.�東C�����`�1�]7&ę+�H�CBcX�B7xX�|1��0��a�6��ubpJLǅ�(���mbl�8I�*R��@tk0�����xX���;�� al]4s�t��Ū�0�c�'��l�`8M�8����D4w`p?@706g̈~K�\r�� �P���bh�\"&��\n�q�PD����\$�(�0QP<�����Q�!X��x��5���R�`w/2�2#���� `���1�/�܁\r���:²����B7�V7Z��gMY�H3� ��b�	Z��J���G�w�gl�^�-�R-!�l�7̲L��ư<1 �QC/ղh��)�W�6C	�*d��6]VK!m����05G\$�R��4��=Cw&[��YP��dɚ�')VK,�5e�\r���K+�1�X)b�e)��uF2A#E�&g~�e�y�fp5�lYl�Ԝ5�����\n�m}`�(�M �Pl9Y��f����]�Vl-4�é����>`��/��fPE�i�\0k�v�\0�fhS0�&�¦lͼ�#fu���5	i%�:Fd��9��؀G<�	{�}��s[7\0�Ξ3�ft:+.Ȕ�p�>�ձ�@!Pas6q,���1bǬŋ�ZK���-��ar`�?RxX�鑡�V���#Ĥ�z�; �D���H��1��6D`��Y�`�R�P֋>-�!\$�����~π���`>���h�0�1����&\0�h���I�wl�Z�\$�\\\r��8�~,�\n�o_��B2D����a1��ǩ�=�v<�kF�p`�`�kBF�6� ����h��T T֎�	�@?dr�剀J�H@1�G�dn��w���%��JG��0b�Tf]m(�k�qg\\�������ш3vk'�^d��AX��~�W�Vs�*�ʱ�d��M����@?���}�6\\��m9<��i�ݧ��Ԭh�^s}�-�[K�s�q�b��-��OORm8\$�yw��##��@❷\0��ؤ 5F7����X\n��|J�/-S�W!f�� 0�,w��D4١RU�T������ZX�=�`�W\$@�ԥ(�XG��Ҋ��a>�*�Y���\n��\n��!�[mj���0,mu�W@ FX������=��(���b��<!\n\"��83�'��(R��\n>��@�W�r!L�H�k�\r�E\nW��\r��'FH�\$�����m���=�ۥ{LY��&���_\0����#�䔀[�9\0�\"��@8�iK���0�l���p\ng��'qbF��y�c�l@9�(#JU�ݲ�{io���.{�ͳ4�V́�VnF�x���z� Q�ޞ\$kSa~ʨ0s@���%�y@��5H��N�ͦ�@�x�#	ܫ /\\��?<hڂ���I�T��:�3�\n%��");
	} else {
		header("Content-Type: image/gif");
		switch ($_GET["file"]) {
			case"plus.gif":
				echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";
				break;
			case"cross.gif":
				echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";
				break;
			case"up.gif":
				echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";
				break;
			case"down.gif":
				echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";
				break;
			case"arrow.gif":
				echo "GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";
				break;
		}
	}
	exit;
}
if ($_GET["script"] == "version") {
	$md = file_open_lock(get_temp_dir() . "/adminer.version");
	if ($md) file_write_unlock($md, serialize(array("signature" => $_POST["signature"], "version" => $_POST["version"])));
	exit;
}
global $b, $h, $m, $ic, $qc, $_c, $n, $od, $ud, $ba, $Vd, $x, $ca, $re, $vf, $gg, $Mh, $zd, $ti, $zi, $U, $Ni, $ia;
if (!$_SERVER["REQUEST_URI"]) $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
	session_cache_limiter("");
	session_name("adminer_sid");
	$Tf = array(0, preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]), "", $ba);
	if (version_compare(PHP_VERSION, '5.2.0') >= 0) $Tf[] = true;
	call_user_func_array('session_set_cookie_params', $Tf);
	session_start();
}
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $Zc);
if (get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
$re = array('en' => 'English', 'ar' => 'العربية', 'bg' => 'Български', 'bn' => 'বাংলা', 'bs' => 'Bosanski', 'ca' => 'Català', 'cs' => 'Čeština', 'da' => 'Dansk', 'de' => 'Deutsch', 'el' => 'Ελληνικά', 'es' => 'Español', 'et' => 'Eesti', 'fa' => 'فارسی', 'fi' => 'Suomi', 'fr' => 'Français', 'gl' => 'Galego', 'he' => 'עברית', 'hu' => 'Magyar', 'id' => 'Bahasa Indonesia', 'it' => 'Italiano', 'ja' => '日本語', 'ka' => 'ქართული', 'ko' => '한국어', 'lt' => 'Lietuvių', 'ms' => 'Bahasa Melayu', 'nl' => 'Nederlands', 'no' => 'Norsk', 'pl' => 'Polski', 'pt' => 'Português', 'pt-br' => 'Português (Brazil)', 'ro' => 'Limba Română', 'ru' => 'Русский', 'sk' => 'Slovenčina', 'sl' => 'Slovenski', 'sr' => 'Српски', 'sv' => 'Svenska', 'ta' => 'த‌மிழ்', 'th' => 'ภาษาไทย', 'tr' => 'Türkçe', 'uk' => 'Українська', 'vi' => 'Tiếng Việt', 'zh' => '简体中文', 'zh-tw' => '繁體中文',);
function
get_lang() {
	global $ca;
	return $ca;
}

function
lang($u, $mf = null) {
	if (is_string($u)) {
		$jg = array_search($u, get_translations("en"));
		if ($jg !== false) $u = $jg;
	}
	global $ca, $zi;
	$yi = ($zi[$u] ? $zi[$u] : $u);
	if (is_array($yi)) {
		$jg = ($mf == 1 ? 0 : ($ca == 'cs' || $ca == 'sk' ? ($mf && $mf < 5 ? 1 : 2) : ($ca == 'fr' ? (!$mf ? 0 : 1) : ($ca == 'pl' ? ($mf % 10 > 1 && $mf % 10 < 5 && $mf / 10 % 10 != 1 ? 1 : 2) : ($ca == 'sl' ? ($mf % 100 == 1 ? 0 : ($mf % 100 == 2 ? 1 : ($mf % 100 == 3 || $mf % 100 == 4 ? 2 : 3))) : ($ca == 'lt' ? ($mf % 10 == 1 && $mf % 100 != 11 ? 0 : ($mf % 10 > 1 && $mf / 10 % 10 != 1 ? 1 : 2)) : ($ca == 'bs' || $ca == 'ru' || $ca == 'sr' || $ca == 'uk' ? ($mf % 10 == 1 && $mf % 100 != 11 ? 0 : ($mf % 10 > 1 && $mf % 10 < 5 && $mf / 10 % 10 != 1 ? 1 : 2)) : 1)))))));
		$yi = $yi[$jg];
	}
	$Fa = func_get_args();
	array_shift($Fa);
	$jd = str_replace("%d", "%s", $yi);
	if ($jd != $yi) $Fa[0] = format_number($mf);
	return
		vsprintf($jd, $Fa);
}

function
switch_lang() {
	global $ca, $re;
	echo "<form action='' method='post'>\n<div id='lang'>", lang(19) . ": " . html_select("lang", $re, $ca, "this.form.submit();"), " <input type='submit' value='" . lang(20) . "' class='hidden'>\n", "<input type='hidden' name='token' value='" . get_token() . "'>\n";
	echo "</div>\n</form>\n";
}

if (isset($_POST["lang"]) && verify_token()) {
	cookie("adminer_lang", $_POST["lang"]);
	$_SESSION["lang"] = $_POST["lang"];
	$_SESSION["translations"] = array();
	redirect(remove_from_uri());
}
$ca = "en";
if (isset($re[$_COOKIE["adminer_lang"]])) {
	cookie("adminer_lang", $_COOKIE["adminer_lang"]);
	$ca = $_COOKIE["adminer_lang"];
} elseif (isset($re[$_SESSION["lang"]])) $ca = $_SESSION["lang"];
else {
	$va = array();
	preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $Ie, PREG_SET_ORDER);
	foreach ($Ie
			 as $A) $va[$A[1]] = (isset($A[3]) ? $A[3] : 1);
	arsort($va);
	foreach ($va
			 as $y => $zg) {
		if (isset($re[$y])) {
			$ca = $y;
			break;
		}
		$y = preg_replace('~-.*~', '', $y);
		if (!isset($va[$y]) && isset($re[$y])) {
			$ca = $y;
			break;
		}
	}
}
$zi = $_SESSION["translations"];
if ($_SESSION["translations_version"] != 424438045) {
	$zi = array();
	$_SESSION["translations_version"] = 424438045;
}
function
get_translations($qe) {
	switch ($qe) {
		case"en":
			$g = "A9D�y�@s:�G�(�ff�����	��:�S���a2\"1�..L'�I��m�#�s,�K��OP#I�@%9��i4�o2ύ���,9�%�P�b2��a��r\n2�NC�(�r4��1C`(�:Eb�9A�i:�&㙔�y��F��Y��\r�\n� 8Z�S=\$A����`�=�܌���0�\n��dF�	��n:Zΰ)��Q���mw����O��mfpQ�΂��q��a�į�#q��w7S�X3������o�\n>Z�M�zi��s;�̒��_�:���#|@�46��:�\r-z|�(j*���0�:-h��/̸�8)+r^1/Л�η,�ZӈKX�9,�p�:>#���(�6�qC���I�|��Ȣ,�(y �,	%b{�ʢ���9B��)B����+�1>�P޵\r���6��2��L�P�2\r�\\*�Jb�=m��1�jH��O\$�����4 �jF�o���F4 #0z\r��8a�^��\\�N-�����|�єp�2��\r�:x7�<�ص��^0��#�2�jk6��@��������ΎA&2��u�\n�1��lĠ+��s�	���<��M�]l�&!��b_2���Oz\r��a7���1�7�����i��\r�ӊv�è�b����3����c2�N1�\0S�<���=�PȤϭc��%����������_�accC����\n\"`@�_�d�7�(��[V�n�6��9��h8�k��/k˯K,�)�+Z\"��󰌻�����\"MF�����'iʌB\r��0�6NRL�D�B�ލMp򍯖t�F��^s1�t�!ͺ\n�p�7}K��`O-�d��>O��6t��P�c�_W�6W�P���pҐ�b��#2�x�#�\"�2�I]xP���L��tZP*1n�}\\گ�7ԫ� �@�}�I1T�/L�t�>�C��N	�S�%R��9W��X���j�X	F��I�@�����˩-d��\$���R��\$�꿅(T��SJqO*D�  .U\n�\$T��s���h\$�� F��7�0���=��4�(��zw=G�%����>nU�'��I3B�`9>�hHCfknyܺ(A��l��4�4��K0�E��[��B?�h��bj�H\n-�b|\n\n\0)\$D�<�Lh�B�\r���עdq2����@yɉ3���7<� kc���!��>��O	�#g�>�����2	l�(S>�\"QiS+��&�~M)%d����6�O�0�<��p�O�z}&��Hc�Z�\$H\$�A��!����@@C��*\$����#��dx���|{���r����\0�£W/T)U�5h�BZ���P״�_�%9�ɐE��@X��%)���2G��TT)��H���#�RI���܍�x��̃�\"�Pձi;/M'\0�\\L�je	�8P�T�*��\0�B`E�M�z�s}\r:Z��-\n�sN0gg�<���&����%!���j�9�TuZ��i-�]L��7�,b�RHǐ���f�\\2Ʋ́�\"�xN�P0n|�9���'�(�	��8~Ha>JrD��`èg\rBIID�!��bc�<�[ҁb�l�zU��M�'K�̓�h!�K�����H[Zh����<�vHV��\n��l]��^�xxC-i\n���B�I��@dV�K�n�ڨ�z�K(T-,9W��I�J�B*�`�KZ/	��1Etg,Z�NHL\"��`���o(�l%J�C	\0�����0d��O�Y�S��^=F˼�HLw]�@�!0�l��OX�����~Q\$N:�������A�.��2���a�2�3�������ߒ�U�͗�7�]���X��/-�L�]t�f�Ħ�&Q	��	wL�:G�ӌ<���0�AjhrJ`(+�P�o�?'<)1md��pHGd�Œa5�l�Y\n�����9eg�*j�ËhI3��œ�4vYyȖ{H����5,�X�oi���ɻ/׉�ϵ��PC�*n�rԖ{բn��f�cވ����,0aL2[P#�gQ��F�3������~����AnlXz�h�Y���x氧��+b�\r�d3��In�\r��-�f�%��vU�������э�ݽ��D~�rϦ�>��,����)�5'��B��{���'d�����0��1KN]�x4bdMs����:,\\��T��t׻���fd�ڛ��7���aƂ\n��:�Z�X���/-�<�\0��LZ�\\p1M��ܟ�ɦ;S���!�Lʈ���\n�_�[O�D�W�V�g0^��^G�Ot��]P�;�������}'F�4���o���~jY���;c�ކ�z8����X�5~��g��������\\)��-������F�\0��5P/ �5��Jb�	������\")*��#b�N���%\0�P<���H�p:���\0If���t&.��`�\0�O��ZDdg���@20n��V���!#�,�`b,z����/�XP����Ф6p���P%j/��_oF���r��	�C�0��\\�pk	P��oj4�\$�\$*�\$ތ&�O������\n��\r�R�)b1,\n�G0\n�y��%�>&0�J��\n͌<D\0K�T�\0�������zCN]�����\rh���P�d���p�X�B#�~��#\"�-���1t\\M���έ]��f�/\0`�B\0�j\r �\rmvP.#0����6/'��V\n���Zz5��9���/�%�>m�ͼ�.�L��b&G#0p��o�����\0ث\$&6��b�.���)NV��ǲ4�rJrV�8���\$fKC�!+^\n�'�ab�߂��N�%�b�о�Z�\r౭��2]������v���riQ�f�6\$���(\n��+jo,�ohurC0L�N�@�vd�F��&y+�N��R0�`O`�%�ȯ��Z\"�\"vl��=�2r��bƌ92\n5C0)�T�D�0+�ʰ���л���jk�ro��)����DK��ZML���*M3�@����3F�";
			break;
		case"ar":
			$g = "�C�P���l*�\r�,&\n�A���(J.��0Se\\�\r��b�@�0�,\nQ,l)���µ���A��j_1�C�M��e��S�\ng@�Og���X�DM�)��0��cA��n8�e*y#au4�� �Ir*;rS�U�dJ	}���*z�U�@��X;ai1l(n������[�y�d�u'c(��oF����e3�Nb���p2N�S��ӳ:LZ�z�P�\\b�u�.�[�Q`u	!��Jy��&2��(gT��SњM�x�5g5�K�K�¦����0ʀ(�7\rm8�7(�9\r�f\"7N�9�� ��4�x荶��x�;�#\"�������2ɰW\"J\nB��'hk�ūb�Di�\\@���p���yf���9����V�?�TXW���F��{�3)\"�W9�|��eRhU��Ҫ�1��P�>���\"o{�\"7�^��pL\n7OM*�O��<7cp�4��Rfl�N��SJ��\\E��V�J�+�#��܇Jr� �>�J��(ꆶ\$(�R�M��v�GI������ťr��Wj�|�\"v���< ��k��(���3\r��1�T[�nڰh�����޳�����\0�2�\0yw���3��:����x�\r�i�PH���p_�p�B�J`|6�-+�3A#kuF\r��^0��zC�ܪ�����s��j�Q8������u,15���XrZTƖ��n�\"@P�0�Cs�3��(�Z(�f���\$������:��Yk���U��<���:����0�����ŋ�l�SR����i�Z��)�v�kR<�J�#[�q77WSI�Y<ь�l�MT���K���#oci@�c�7S����b���!�jh�;[3��!{�cT����\\!>6}�TT�o�1lk�Ȧg�[���H��rǙ`yٍr�1��a��]�7��(v��p�ý6�+���q�yj͗�g<�� Bld5�=����r���@�\r(o��6-3\n~3�X��� y�dA�<�\0ꢃ��\\!��\0��9�k�:(ZC8a=@�!��@��pu7`�9���I�h�)� �A\n�\$��\n�\\��j&Hh���˒Ko!��+4J��\$(����x�YtrHJ�Ɨ���9�@͐(\\��8 Z!/PƣTXdZ��Я����`��0��C�b �	(\0���>�����fPS��{�%��䝆��*��4\\ �\"WV%�+�DPVKI&a5�����@��8�􈗲������X8wa,,7 `\\Ø�P�%E��0ƂHm�6��+��|��v5�k�kc�qB��ʋ�2����s���(1���0�\r*ޔ�4.����B�V�C4�CɊ�Ge\r��]F��Q�6g� s^{����6G-�,�b_\nۣ}�9,�#R�`E�����	QI-GHU\$��0��g(c����Xk��ekhj	3~�Wu\r�޵���t�Yq`�Ŷ��	����a}DCf�Ú\\�<��J^Uy5��o�h��3��AHi��v��(�|P�|ď�m�����I� ���s�rԊˋ���#5�I�d�O��\$���g֨ikk`���o���-�9�p̂l���R� @�\rЅ5��tب���k��@'�0�Bȋ΍���۵\"�Y�{R-��Bl⪕誵8������VO\$��i�J�+}���Fp�����xn b���ބ�@�@ 5��#@��Cs[\r3�n.�Ov.hr4�(��ttUEl�+D!�&ŀ��y\0('��@B�D!P\"�̜(L�QO�U��*N]T(��U�4�`pxP�b�J`&GJٲ_�O���%�%&)�mҺG&)(�!\0�nq(5��Z�A+�A�1�P�a`K��K�F3\$F�ٻ��-��N��<ZXh���lMX9�:�T�Oᆫ���K�A�E��A������Kͤ�뚇lp�O�uP�Y�ы�zz��\$����ɳ�r\$9�3�h`\n\0\na�=7��<�S\na���*���(|04[�ȵ�\"��7H�A����he�ѕ�����d�6��{�1�[�?w�%�T/I���ުj9)K������Σ�zᙺ��N��Jp�?Fw�j�9P��\n�4QH������Ol��r'�����ޫTfR��C	\0���D)+��ݢ\$�hS�o���~�ڞ���f�\\�{�U��ʤ�R{ńh�����6�(:eE�\$�J\r�2e巤&�A�:%�瑲h2>,4�����\"�΋�_M�\"?P\\|#o��WģO��m�G~�>�	�Y\"A3�d��^�5�r?�J�?��<��!/1�*qS\$���>�E��N�����)����e��R���Rn�b��F9Ap  ��&|G���|���|#�xN.g�Hg&�/m*�\$���\$�S��.C�u@ڄ`\"g��]��0B��~X��PQM�i�0�n�\rT�� ��viN\$&�ple\":��wnT-����n��\"��z(e@��4�&x��H�׍�	��,	P��#�x�?�5��+\$��P��l��B���%5�oO�yM\\ԭ`�ͨ���0��y�v��>��ʀm8��0}qԇ�\r����:|�u08�M�G���o\r��\r��An��T\"bBu�r��~+g ���&\\��#.M���ЮX������h1h���k�]0{��TC��q�1�j)��!�<U<�\$P��\">/�P�/�m�r0m��c�gNI��*��Ix11��B\0�	�*�*.f����D����\$�F�b��<m�/r!&�D��1��[Na���C�\0�D�|��py��H�cqGf��SPZ-��mS��)	a��(pQ(ȺE�WR�-��)G�*+*�>�+m�r�,Ôgb'\0g�l�fu�NiG�9	�\$.Ic\0�}O���;b��\r+�(N�0�])r�(313'�0/32Prub�~�%-�<Ds2�9+�=3�2,��Z���/�c0\\IC��34S^�se(3a65	7sA-=8�qVRĝ6n� p�,p�!d��Q6��%S�5�bsċ7�;.g9Q�(.v����u;S�9g?=�L��*�&�sY�hT��\r;�\$JS�<�U�S��.G�ts:�ǯB�f�-���NE���2��tf�#5�m,�/�bQ�En�\"J�qF�-�8�\"\"t'âi�/�P)4>@����k�\r �\re@��of�7�T\r��\r ̅��&`�� ڴ�.��\n���Z���=pB��x��c7�+'�\r�F��@�p�i 	��I\0��vn&grrE't'�\\���PpL�7���UP�?�4	���8��r8/�Qt�=��%+SHⷃ�3�.��y/�z��h�?ѢI��:��0PyU(@LYT�_>s�&S)��P#f4CH���b%	NZNG��U�L;�^K²hD�F0\0�UgW.\"U�\"i�l0�JpaT)���P�Y\r\n��L.P���Z\nż��\r��64�\nIc�&�S����T��Uc'�m�Ӵ..h�ό�ДB�\r�v�V7e56\r�_RRV�KO���h?��K@�	\0t	��@�\n`";
			break;
		case"bg":
			$g = "�P�\r�E�@4�!Awh�Z(&��~\n��fa��N�`���D��4���\"�]4\r;Ae2��a�������.a���rp��@ד�|.W.X4��FP�����\$�hR�s���}@�Зp�Д�B�4�sE�΢7f�&E�,��i�X\nFC1��l7c��MEo)_G����_<�Gӭ}���,k놊qPX�}F�+9���7i��Z贚i�Q��_a���Z��*�n^���S��9���Y�V��~�]�X\\R�6���}�j�}	�l�4�v��=��3	�\0�@D|�¤���[�����^]#�s.�3d\0*��X�7��p@2�C��9(� �:#�9��\0�7���A����8\\z8Fc�������m X���4�;��r�'HS���2�6A>�¦�6��5	�ܸ�kJ��&�j�\"K������9�{.��-�^�:�*U?�+*>S�3z>J&SK�&���hR����&�:��ɒ>I�J���L�H�H�����Eq8�ZV��s[����2�Ø�7ث��έj��/t��Z��.��O��m�5�cCmҨL�X#�ĳ8��Q��B�ŤC*5\\ �ʰ��2\r�H�F��uG��#���pφF�|cƣ��:\rx��!�9��D�d#@�2���D4���9�Ax^;�pÀ`Q@]��}��y(�2��\r�\\k��X���px�!��n9)�-	;�%��^\r��jʣ��]U8{ā�����{v��M;��@O;D�Kb��Ur�\n��7`C:<��kT��`O)�(3J>M+�{��PH�htT�4�� �S�P3	��8�i�q~���c+3��C%~#���po	ܚ���8+����yqj�L\"�=��w���V�H�y��4�G���(:ں,�yޭ\"��#���w��DX\nA�Re�+��n@ދn{%4��׉Je;�d�&�yVq�AL(���!)?FL�A.���Pǹ��f�x!��B�p���ۡp�n+�\n�%���[{Z��qa�`9�V�H����!��w���t��4�H�4(L	\$\\x��/Wsaoƥܸ%b�iTA!DȔ��4&l6@��N��;�l���/K�~�%�È\0S4\r4�h�<S�H�Q&*��3�Ӓ|ȡ��d4�/I����s�0�x��8 sf���2��LWQ0A��Y&W��y�\nM�=\nͩ�]��zʉ>��Y�\$��W��i,���KDP�Ұ�O*�|��2��wK�.�8���	)������&�<L�XK�C��t��h�*x��=\"P��R]ؖ�mI9�(�P4B���rՈ�5��XrI�d,`��@ eL��3d��8��R~�CF��:5V���TbM]������[���q�iKI�:RK�+���7�Bx���z��U9�(X'�+3��ҶZ�ً3f�ݜ��@ϚB\r�	a,E��KKA�X�S�* >�H��OIO2����|;���b�y3m������T�z�Cڎ@ϳg4�����^��S��^��Dj�i��h6�@��pEd6�W*C2ãA�:�� ���\r��3�+v��@ c��Y�P@�]'\r��0���s�L&X�<�#�	x�<cf-��T�yp����A�D�sHAn%楚0�IQDk!��:zĮ�odA�4�`ҭC=�dI	+\$v��D�o ��l���Q�p-4��\$T�4L4\"����sH�<]k��Cppc�\"�v�n�@iwe��vaoѮGa��T�mQJ�ɞ6�.ejS����(�{_\$�	,����`��\$R�5��{%�\nyK3��D^yO\n�GX�ҹ�J��}��+ j�T�pX�ړ\0�\\	��F_B��DV�8��H�R�%\$�:L�Ȑ��!=�q�k+.�4Fx,�\\X�meJ�7�&���%ڙJ�i%�w/��K�[mB�T��Գ%s�ar��Zɡ��A*`r�&	/)q��O����u�[A��mJj	����>s��Z�4+p���] F��(�j�'�7DV\\��Z=r����V�xU�m:A�'�����P�;�wY�D�6s�D�x��4�i�u����F++���>lq�\$3~H:hb��d5�EO��\r� �~��U(���*���j)�Xdu�wX�M���{-�7P�1W�̄�L v�3f�<Ei�<��bAY�\"�U�ʋ�����et� ���^ݡ��i�\0���ӌ��5\\B���?�˄ѰM���ʠ87�*.\0�EnG,Y�n��n\$��3���?���\n�/<�&��Ԁu��!IA��.�ݍ����b7 ��#a��*78E�?���_\">)�����F�g9��+��5��B#<��V+�d0O��� +���6�HvlM �\0��A�\0u�.I��2��?\"F!.�7�D��PF��P [���@�\n�� �	\0@ �E\0�G&elNG��a@�Xd�T�4%���._�s�6�@#*8�hsP�Q(F�ѫH�I�J)�'\"�I�7\nʖф+<�)q�+	о]�H�yв6G�N��\rB�\r��9�؄���]�	c����mP�����'�qP�{MQ��+�2�o��D���m�QpP�K�M��p-�qc	�jzP������5-@��|.!</��-�[N�%њL��M����J%�1��ѨZ	�yi�3� �f�)��H�\$�m��	#z��>��;N.3���m��/�*����Br��@Bj�(���������� \"b�B�up�!����R�� ��|�j�.��N���t{\"b�1H�f��+�-.�R��%��%H.�-�%�0oR�#��RV��Zs��N�����H�⏖o�X]��Mvw¼(G�O)DJLҴ�Ʊ�8 �E@�b/���\r�8�2��h�AҘ��b�E\$��*�+�������\$E��+H7GL��.��R+�F,�Px��T�\0S)g�]H��\r|�Rt�N�&c�.34�s8�N��2vQ,�#�n�2~Jѐ�3��!����q)-E6N�4�Q6�.��0�blϛ(mu!�!4.0����r5M�Hk7��~��\"��8�sb���º��}(��<b���`�0>x��&P�L#�e53�\r��=+=M�'��=��>!a>p�Q����+�Q�����;��/�4D�ߥB�%ӻ0Rz����¡rs:�r�£;�1�.�ʰ��bwD�� �<(��c|��^:��c@}Bl��L��8kX]��J�3�@fĄ[/�\n�	~�E.�1VNxwx�S;C�CH�&�h�3Ҏ�fC���\0�]\0�aJB��π��C�''�##qKO�3�B����d]�?D�Lŕ(���`��\0t��QK��{8R`��gB�cQ���0���8t=O�\$�uD�i%Q.�E�)��M�x4��Ug�Q�� /�V頾Ao�P:ar7'���d��I�6K ;e���%�m@tGBS�B�e9�{Z�e3�PUN��AVt\\TK=:�}Vo�V�~zh�?�_M��דm��@��VX4�	^����:�w-S�_��]R��#I�����\$���M�B�TÍP�Q<2�P�ac(ce[c�WTS]�b��d�lx-?eSV+�>����N�3d���vh��+`�=�Gb�ehR���\rP4:\$I�[�ܐ�T�Wa[O��_2Pu�v�lH8��P�v�f�S�k\0�Q;O��!V�mmU]e�c^x���n`�t�6�p6�jU�&5sT5~��\\[�.ε5m��j���,��mn�;�e�Ɨ&�7+:�o��2\0��_���� �B�d\")�Big=��@u��b�AP�w�Rrη_iwxu�A�Q1�#����� �����.��	fQ�:qWO4�B�i�|nqUyb��y�\$���b�:bb�G\n�i�S>K!G�;\\��Q����IwKD�\0�\n���p�I��`k�#s�s�VމB~7�>�}Ԙ�Hǃ��z��i4���+q�p�)҄�Vv�n>#���e�@��Y���+�N�\"tX�^��X;��o���D���fQ%J�O�x��wD�3�T��y��tk��(I�|�����V#�&�j�ו0����4�%/��8�/���;*Lw�t�^ʱ\$9����7�L�Y�9\$uj�&�������ؓ�j�M:�#�x�K5%P�|5�Av׳P�W���\0A%��a���'2�+3�m����\"��Q�S��]�^ooa�9OZtbHJn�u���Z�9D���u�OټA�����ǚ�<��u�<״_H\rh�\n�3�8�Ƃ/�/�s<�>r�@��P�8Xv^AV�h2�Ȭ֢�\\�t�A%Z5�׭q�>8\0";
			break;
		case"bn":
			$g = "�S)\nt]\0_� 	XD)L��@�4l5���BQp�� 9��\n��\0��,��h�SE�0�b�a%�. �H�\0��.b��2n��D�e*�D��M���,OJÐ��v����х\$:IK��g5U4�L�	Nd!u>�&������a\\�@'Jx��S���4�P�D�����z�.S��E<�OS���kb�O�af�hb�\0�B���r��)����Q��W��E�{K��PP~�9\\��l*�_W	��7��ɼ� 4N�Q�� 8�'cI��g2��O9��d0�<�CA��:#ܺ�%3��5�!n�nJ�mk����,q���@ᭋ�(n+L�9�x���k�I��2�L\0I��#Vܦ�#`�������B��4��:�� �,X���2����,(_)��7*�\n�p���p@2�C��9.�#�\0�#��2\r��7���8M���:�c��2@�L�� �S6�\\4�Gʂ\0�/n:&�.Ht��ļ/��0��2�TgPEt̥L�,L5H����L��G��j�%���R�t����-I�04=XK�\$Gf�Jz��R\$�a`(�����+b0�Ȉ�@/r��M�X�v����N����7cH�~Q(L�\$��wKR���WF5\"�,ԕ�_-�eR��������S�8u*P��\nِÕ�8���XTAԩJ�����P�2\r�d�O��>�s�#��߲n��Nc���K��O��BPÐ��4C(��C@�:�t���9�}8M�8^2��}9д8^.A��7��`�7����7�x�`(gd�7Dz·+�/FQ�����1A8ՓI��iҮ\"�)E�/�)�T9tUԱM�/i�����78<��5�~�B��9\r�`ΐ��%=k�O���\n�@�ˢ����!kR{{J�T�L�84�sEq�\\�Ƕk��0�]u6`�Cb}��6Pʶ�Ûwnx�%C�����|d\r��d^�9U�s��@AaJ,�������0��⭶��0|�Tծr��1��)sn��,!�\$D*�*&\n#�p����\n�@l>kА0��HQ	��Jj�Vh��٢u��Bh1��r�gqp�n���baI����0txQ1&����1 �|MC	SH�LɎ+(T,���Y#y����%h�m��w�qE�% S�tHw�`���>�M��7�S�\${%:&Q��Ǆ�� B��A<E���s�D��� wN��<��3`�ϔK8İS1Iny�q��<�\0��Ji��\0��:Lm�:)�C8aI�����z�������&䐧)� ���Y�-�@��h�aEq+�h�B�N����S�s;@�Ԭ1���Y��\nf>N,9N��;�鱰5��C#?lG���v���kon-ͺ�6���|��y�G���\\q�5ȹ5`�r�/n����\"j�[����1{lrM\"l����n܁�8S�ju?T�������p\r-�D6�S[Cjm���7 ���nM�������W��_�\r��pmo�Ҳ���-�W{G����Tl�vγ�x2���3uFYuaa�|wu�/�#N#I���5P���	��['�C5�O���OH�=��jj�������\r���[0���:N�X�B�M\nUjuԓó��H\n\"WCFYTlr�&��\0P\\�M%F�\r���i�ɋ)�\r� �W�u�='�������\0r���'��w�xw��\$�%z�+�R��]{��h!�kA�A�����\r���\0�^�w?��4[���P �7��E�Ꝩs�J&���,/G��D&xf��Y�[ #+(c�H)�{�E�H]`M�y;f�%]2b3���n�M{��d6J�SzcI'y�����|�g��6P���}ɸ6�B���js�;_\\z�ς�Y	D�;�0/0�O\naP�I�@Uh�Ó:�a�L�<� :8E�Hh�t��)E���VEZp\\(�F���C\0����)^l_��;��on�<1fp@� ��ƴ����h4���ոV��!������j�+4D���u��2ee-��2a��v�|n�շ��Q���#,۱�Ϣ\\���(,��C�\$Xд��v`��\n���*×����j(z>9b����`Bç��Ð��x��kDi�m�z������HrP J�+(�]��*�&+�LB�1�{��L�9������<��/�?���y�J�\"(�s蜚�Ȩ�[�l�J�IL)Q:��.���p�ϒ���QLD2i|�glHQ���TDc�����+\$�j�F\\gΫM�'�J#+)u����)\$4���-}	��L2��_���Q��S�L.T���i��\nR��M�����{C���u��)p��Jf\$\"���(8�����D�ǂvh��N�e��yd�F'�̐8�2��0�%�\r��%���g�ݥ�϶��y\$��P�o�y�L�����԰�@�ĺI���0J.p���Tj)�{B0)O]o�U�<�b�R0��:�N��z�H�Δ�pz �\n��`�\ro��L|O���#�Q��f�Ȇ���̊�i��P\n#g��A��~{Ǵ@�<v�QH�W��E�t\nf�j�.1Bw�F���bv�歷��(����0p8PF�q]�z(�o���D�pZ1t�1��o604���	(G���L�'4�k�s#���q���dQ����h�c�����/q@��Č���R�p@�#�,�O��j_\ne�k'i���0M��\$(-%Z�QX��Q�#�z��,,�������͠ԫ��q���D�q\$Xr�ܣB��Is'+����\$�X%B��L!�>/t�`y�rx�\";X���'����X��2l�-��5P�*��7O�6�V/�/%�`�G2�pz@�jw�ڥ�Hc2��Z�皑\n�-L��\n-�jiѴ��R#s	��2@�n��&�^��Z��2'w2�\r�\0Ў��.Am1�a'd-��w�1�1M3��V����g�Zv��5��Jk��6IK�A\n2i8�u&�61r/O���\rE*H���.#\rs���M��]�5����cJ�(�4��p����0b��0�.�}λ4�8a=4	 ��/��8S��Ӎ1�,�a 5hN�%�\0P�3�0��K�R�Ҏ���0ǎ�o���9\"%����?�0�b���3d-A�]3�yD�h��R�1UGӋ1�?FI4��!��xrk3s�F����k6�X3SqE�bV3w6���W&�>�����Ls�L�ۑ�\$2�AɃL�:ES/0�0��?I����Xr�(��C�\n,C�G!E�U1рC�;�.w��B�'�?;MT;g�Q����,�95�,�Ӝ�tW!t�}�B4�U�8����(;4�G��U5tVO/V4�JԂ~�j�Š7!P�D0�.[�2\\����گZ�XRz-�jx�\"LH�tg'U�R��}5[eM*�;@�Qդ!�_)j}�r&U���x�C	�,Y��	�M8��,�!���`H)q>�M]� ��w��&	���75u	C'p#8�/՗W�eu��UhJ�sY�`K6c9��N�oS�ru�yYM��2�\r5�]�g&�V�WH`-֐�oeT���7XT�V���hiX4�U�Sk��<TJ5�Ԥ�\r�j��h��m��0��\"C��M�G�,�['��/���L6\$&1\$hR�)5i-3�u�f�]g��W!=��Nue�}i��s�v�f�[hZ-�1sueA�eN��h��5b�`�h�l�J�A����A5�l6�vO�w�l#\nc�t֋O���c\\�}�b�R^ �Uf��V��J�\rj��S���n5Yw�t.�ҷ�w��w�����W�U7�x��~�ww_w�O}��J7��7��Wcb�=\\V�6�[K��O3�U)4-���AP�>�w�kx\\)	c�t�2���[t�c�/�� :׷i�oiֵ�s{x�����s�a~�gF/e��/p���8ylw1��/v�s�U����H�g��\r�qlӴV�Tb��(�'{�mE�]j6	���s���Wr؏�p�瘆�����q�@�Is4�d�/*��j�/z3�M�AQ��QUHTUM�k�Or����N�yA5|��6�x�ͼ�R*,�VB�R!U�A��m�S�ٓ�#2Iy�-�WR�Ro�i�\r�V�`�`��kH����@�����j���\r��O�֠`�\n���p^J����.�m^�!�G��LaiYY�%�Y�7�+���-Y�+�J!��+9�8��a7Ӗ8�&ӣ��ˡ\\�(�D(a���y�2%�]\n�u�I�Q�#>'@GB1c��}��ȣ~7�&�l 2\\'�d�p�c���G�p�?\0Zrn���MC%�L��P�ꮚ2D�'T{R�!'cnj!8��;VŠګ:�K���z����:��\"j8����є��6u��{��xh���>C�<l�������{e�yZ\$:��wQz��iL!�R W/��;�R�l�-p��B9�T)N]'��φ024>鈢)�r�eQ�:�\nƒ��\r��8���H�6:��.�觖oS>��\"��\"�lz�\0~u�D�h���`�ϻ�@c�(���	w8���N\r�:��?X|��}P�p�D�a�ёo�ƃw�@�	\0t	��@�\n`";
			break;
		case"bs":
			$g = "D0�\r����e��L�S���?	E�34S6MƨA��t7��p�tp@u9���x�N0���V\"d7����dp���؈�L�A�H�a)̅.�RL��	�p7���L�X\nFC1��l7AG���n7���(U�l�����b��eēѴ�>4����)�y��FY��\n,�΢A�f �-�����e3�Nw�|��H�\r�]�ŧ��43�X�ݣw��A!�D��6e�o7�Y>9���q�\$���iM�pV�tb�q\$�٤�\n%���LIT�k���)�乪��0�h���4	\n\n:�\n��:4P �;�c\"\\&��H�\ro�4����x��@��,�\nl�E��j�+)��\n���C�r�5����ү/�~����;.�����j�&�f)|0�B8�7����,����ŭZ��'��ģ���8�9�#|�	���=\r�����Q��9��l:���br����܀�\n@�F��,\n�hԣ4cS=,##�M���B�B�1�S��&��!�@43Ul\"9�p�X��Ɍ��D4���9�Ax^;ځp�Q(��\\���{���(9�xD���j�(�2�6����|��K���R(�FR�p�+;2��5��`�2�4�Q��ӌ�f�b-�W���{,��Th�0��(�9�1=n5�HK�&+�]�e�����JL\r#�x�\r�� ��\0Zѭ�J�#��0�:���-��%��B0���l;�I���4�`��0�����5�8ɲ\nY�H�+�\rC�j��j1���\$NF5��.5�hv��C�h�ӱ͍�Ӣ∙K��<��ް���N_a��n=3w��F��K��n#]��fP��Y�Pv�V���\"')�0*�c�ʝ')x¶9+�/��t������ P�|�ƣ@�,�H�\r�0́��p��������p��c�^�C3P A�3�P����m���S����h��0RK�pe2�X�@�Fs�X)R�v̢ x�������.\n��2������Gt���^IՐg\n�Q�ՆӲt;��b�Ő��b�ZIju��\"�Kuo��~}���yx�5轉pV`b���T觑� �L��5:rQ\nF�������O�X+�8 er�X�=e�՞�V��Z�9E����q9��0�p��K�4�\0:Fp|���D��5؄	T0#G8:!r�G�b�!d�/�L�Hk3k䂚���B���]���?���\"p��:nUO�`@�K ,�We�4��L` fL��]Ù./E�)%��?h�I���ph�� (w��ʫ^���\\ӱVg�Y��FiM9�D�՛D�fpo� ���/��z�LNS&qM\\m\\*�NE���E�K��sf���2h�:�z%�U�C�I��kN��6頑�5+1�6)�7�y����yH�y3E4�uQ1Ct�6f�ɇ�j��f?�n\"-��l�t�%���Q��jjY�('��\0�¤�x�~[�<A_�\\D.�I�R��6e�!&O��A��n�(�*��Gd;4���>��~�oZ��h�@��.4֒w�\0�(+�Q\n��ך�1C��7-���zބl1!L��b6i�	�8P�T��2�Q(s&iYO���\n@U�\"���z�e�=�r��+�~	�z4�q��Ҭ��PvB%�.���.��88�����v^0�׋�(�u�c���Q8ywY;�2m��xJ>�=��[�\$���m�|W�W�S@�;wr�n=�^CNp�h�������{lȹ~a,�6(���o+�����A(1HE�1�0rvHAT\r���ߛ�\rp���|��0���z:A�A7�_��q<Ǡ�=���\r\n�����;��D�2�|L�̦�0d��t阻�\rP8��&��C4��ر��!o��7��~R(f'`k0߲N\n�SE����JM�Y]�|&��p�7mЮbb<�I{؈��0��C	\0��/����A�̃�d��E\n,3h10� �)2FQ��=�gc61RbQ!��65��&T�'dqV�ſ�x�\"��{�Ru0�n��vd>F�5�?�ܡr���E	����s>͹'vE�y\"�\$��g����]8'!��t._S�7X�ۮC^����10\\7��-��7^��>�N�bSɆB�;��1xJ9\$%M,�.���4\$��x��ʡ������H�\nl�����+���qq�8�x�D���IEK�^���`%Q�k9κ�_�: ��%</��C�?�l��L�s]��#N~u������p��|ɫ񋆧p���w���k�~D��������_�ڠ�n�li�l\"���k����\$�(�������\"�������j��R0@����\0	-\\�C�ȃ\nkÞ!�pg�hGFn'�t  P�2.��#�Lx���ȥ��~��d����49�l��a\n�GH��n{L���:'Ϫ%���M�2�����\r,x0��/�n ��LL'O��@���~��B\$Δ�.M�\n��ʢ��\r(���wP@0�bM\"��*����+��d8��	O�\r�\n#M�p<'��� �P�9��tB�:��'�:gt!�SC6mc�@�D�i��b�L 1JxI{p4o� �8.g��j �����ǢF��_��1ث�Mu����<ه��qd\r�n-PD�	c��Nb���)�G��)}��m&�8��b��Q��q��������z�J\r �&� ��n��(cRc�SB.Ec�)�`�h��c�M���\nO�2�Q%	��%�N.��,��&�0� �\"-��VU���fkg&�~0�r�#(aLLI�>�Ą%�����\$ɩ�/��r䃈!ǝ!K�8��g�	��%ą%�b%�p8����(��=\$�g�����*O�~M�2�%Q�	��/� q�-�0�� ͟/M�f�I�!~>%!̯-�PCi3RSq�C�2=�������.2Zgg��c	�䈂t�NTH���6�T�th��6Ґ�n-8\"@*��@`�4&^1F�7� 9�R��N:юUNn�l�;fB ��;(�d�\r�V��Lڐ)\09q��\\ˆ�\"PB	����\n���pM����in,�jQ�!�\$�%t.UB.���\"��6���j�jz�Vac\r�|�P*+#�3�>���s���6c����j+��dT�D\r���E\n�tS����t-hN��d��gXj-���V�̈%&��?t�%t��j��~-UK�gT}At��\$�fG�;���0�iM��L��b����#G]�7�����	�p5�#\0�DL40rۣ(�H�`�I,9Ng��x'�C9�L�8k�\r�z��Oc&��[Cp�!l�u���5Zkφ1b�`��P\0�.�*h1 �@�� �>/��I�";
			break;
		case"ca":
			$g = "E9�j���e3�NC�P�\\33A�D�i��s9�LF�(��d5M�C	�@e6Ɠ���r����d�`g�I�hp��L�9��Q*�K��5L� ��S,�W-��\r��<�e4�&\"�P�b2��a��r\n1e��y��g4��&�Q:�h4�\rC�� �M���Xa����+�����\\>R��LK&��v������3��é�pt��0Y\$l�1\"P� ���d��\$�Ě`o9>U��^y�==��\n)�n�+Oo���M|���*��u���Nr9]x��{d���3j�P(��c��2&\"�:���:��\0��\r�rh�(��8����p�\r#{\$�j����#Ri�*��h����B��8B�D�J4��h��n{��K� !/28,\$�� #��@�:.�j0��`@����ʨ��4����U�P�&�J��)��t9I0�9�˰!�S��2�!@Ԛ\$��H�4��Z��&f�S�M<ը#���P�2&�:M\0�c|BD\n0�cB7��\"���X44��WAÐ��������D4���9�Ax^;ہr?V��r�3���_�H��J�|6����3.����x�B)@�\\�+�\"�I�j/E`N����:!L��%l.�5�\$7┵2�1,[.����+���y&�� @1-�����yD\r��ڽG��)C���Jl�M[�oB�nx�3,T\n;/c��P#�T��/9�C;=\\TT�����Rh8��b;\r�H�6\r�h�e;L�	]\r�3�&ejmT��R�e�2R�D�VOZ���L���V�22�\0�(��������;�SC�� ��8�3��{`��l�>�(}�Ҁw�/��h�[\n\rk^�F��*���P�<V̇r2�y��uO�YI9�����K=���0MJ���x�3C�;���qUO����W	�n(h�0�tF1�a!��\$2� aᄼ�c��j��9��b��Y�)� ���C�@?�����n5Ĕ��e�b�;�o�7*rx����_��3�AW�&B�x*����<#%�,����Z�am-�ay\\+�r��^�K�����F��w���&\$�M���i��p\r!��@�� ��S��xcy�7�t �c�e��Yg����V��[kuo�\"a2p;I�5��(����� �3#t�\r�50�� �J��8/`��r]˒�D�TV�Jy���\"��q��ra���\0�J.!�E�er� Kr��Ua��D(Fl�7��^Ӣ90�9�`�Ʉ0�A����H(P	@����  D�jE���G�!���W\r`i5��I��AQ�ZVDy����\$���;J^xB�TMӠT�v��@������7\$�\$xw0�4R�y��m��t\"	��n\$��\$��IР'��HR*�ADhʠ�bH�y4�9� E6�g=!2�؀���W\"t��g�1�C�n�\n61��<zT �x��0M��JI5b��l*�L�Y�ʖ���q�a�i�C�VBc�Tu��ַ0���o#��1w<�\nC��`�#J��q=V�ֻ�6�A0P�^\$%%N�_��IV�)��\0U\n �@���D�0\"��S���g,����8r r��'RK�Ú\r|�*��B�):�d�0gޤ_[��d��S�FO!�O��\"�\nE+�N�*d\r�*��{��)%��o�C����%u�1;E k��\"�(+\$w*�\$U!X���f��f))���M(�O�T��{��='*�@̓J��P5�9\0����M_1S殟ɸ����*��\r.�\$ܘ���K���l��P�C�{f@a����X+v,z�W���M�%���9�7���t@fй*�ڊѵD��u\0���g�D��ss#S�(��&�qz����bI��4��whiB%k�C	�cd�)�@�B�=#�!�NmH�3@^k.|�2�=��7�MQ��2\\��0���F��Y��}\$�I; ��N�P�����N2�B��os>�H*��!�xϻ�p	�YD�X�\\�i�g���D��G�����.W���6�\r�o�L��T?!�XE��H+\n\0&p�Ӄu�R\\�\"M<(Dռ�;��I�ur(�7�������tllQ��/ULB>&�~]TJw��@0c@M\n�:)�T����BC�b�0�L!��)� �b5S�Ҵ�x���Έx0�a� V�yϨ3GL��,��	���:�7��pߩ�ZL���*y���eM|c{���dK�z�<|�HW���p�~L9Q!�� � ����(V�@/:\"'��A9�]S���5� RP��Z�\nbg�.(�,gt`@Pn�x%���RI/d��@��`x�d(o��HdS�%/�02R\r��{0�pL��*�FxpX{�	D�/\\v���'z|��3O���n|�n�r�p^h��\0��\"��<}\n�����v���xp�=���@�D��?��0n����(�TЂ'0���	\r�W�u\n�j-T�����\n�P6B�.�D0& AZ4��\"���9C�H\0�C-Խf��\0�v�Z���C����E�%�VS\n��F�~�@����Hq���s���@���\0��_o�xf2��_\r,Bc\r�UQ�ŧ���2���H����0}����A�o��q���;MxՄ�z���&j�L�K��[��	С\r���5�����vdxh�&�2(�pWCh������&�2�L�9�}P�K���ѧ� ��;��{\$��\$�y%2W���]&d���2o%T��.`RM'�WH(�\"B����N�Ғ�\0��1�\$c��j���0baR�#�2[+��O�v�,�+�n�H�C�+E\0\n�nZ����H�s+��2�.Җ��0\0	����@��R����0^?�\"@�i!�E��mh2����\"�q��e�D��H/��3���h�3o���6/LU���\n� �L\0�j�R�|�&���&�J��& �ybjB�\n��t\n���Z�#W�P�G�3�ސ�6��A3�#�>I��y��L������r-�%�l4z#�=��=�n�#בV1δ��l0�L*�jb�+g\n�e�s�n2';��\ng�p�H�G�dD��#�&�O�G�0����dd09�(d,�aN��^��6��Tp7�u���]HF,�7�\n0cP�(D���&���u1�f��(�4�4sH�\"��dp� q\$D�,gLG��\r\0000|d0&�\r\"j�DlxW\0�gK�J\$<UB�C�2�.�e?/�2\0003��Ӵks����gm�F�F��t|.����7A'~\r\$x	�P��-��h�\0keR	\0�@�	�t\n`�";
			break;
		case"cs":
			$g = "O8�'c!�~\n��fa�N2�\r�C2i6�Q��h90�'Hi��b7����i��i6ȍ���A;͆Y��@v2�\r&�y�Hs�JGQ�8%9��e:L�:e2���Zt�@\nFC1��l7AP��4T�ت�;j\nb�dWeH��a1M��̬���N���e���^/J��-{�J�p�lP���D��le2b��c��u:F���\r��bʻ�P��77��LDn�[?j1F��7�����I61T7r���{�F�E3i����Ǔ^0�b�b���p@c4{�2�&�\0���r\"��JZ�\r(挥b�䢦�k�:�CP�)�z�=\n �1�c(�*\n��99*�^����:4���2��Y����a����8 Q�F&�X�?�|\$߸�\n!\r)���<i��R�B8�7��x�4Ƃ��5���/j�P�'#dά��p���0��c+�0���<����<�J\0����	R3\$?�\0\n��4;��ގq��B�.��8R��D�'���2\r���@H�����HLȭx���f��!\0�=Ap��~��0z\r��8a�^���\\0ՕrT���x�9�ㄜ9��H��J�|;&��A(��K�1���^0��X��n=}#�C{��S���5��](7�CkH77��0�a��&޶l�:��[7#0���C*�%�0��N[����e�Y�蹼h��8�*G�P�.'��NL�B`�	0��2ˣs+e��&�B&7\r���j=0�7\rq��3�c;�_��|\rc\$D�\r#��[��:��\r6	��\"\"G���_��1���ytgQ/�=?\n\"bn˕� �l#(��1l���8�J��t�B=9!�b�;�AH��������<}�R�״�&�\$-*	#l\nň�Ǧ�w�.�sM���b ���~<�;`D�C�J3<3����%MM24�pV�N�@[\0h#DI��2� �S*��,��S9��ա�~��hn6���j�I�\0\r��@XH�����A9��v�ȑ�A�`a`렄�\0�3�`0��~��B�El-�D�Cg��3DD6�h/K��'��!�0��p ~����νC�m0M.	�d��F���#H��v8\\�1��ML\$7�I\n����ʯ�!e ������Z�Yl-��\"V�r\\+��@�G��i��+p�Á�B��}/�:u�9\rEM)�>O��rUUdJe0EL���@V�(��b�tlESDMa\"	H���˳��V\\�Y�Ei�U��C��[�\nLɵȜ	�\r˱w=�Nڪ+B�?�^D�aPY\0<�y�Fҁ\$�Z9�0��p���!zI	�:U\"���\"���v�e������%/����O�5Eu[�U;G|LU�HH�j\r\$��������J�f\$��'�\n1��A3���IƊ��\0�@�B��G0PTJ\rR�H52&V�Qo\$`2�z��i9)q�IR�\"N�S��Z�҉�M�8f��UD��is1�r�E�b�i�G��Re����]Nd�� �\"\"\"A�-�R^g	�]��,+ID	�5�!i���@f\"Oُ������I��=n4DUȒF(U:D-��Q��E消,��\"�O��xB�O\naQ��f�UBg`i�&�Y�\0�{a)�x3��N��F�����?S�V((�,7:II9V�\"�Ŧr<H	�\r����\0�*��&L�HH��څ�D�!���Z��������BH���X,hҚE(��i����V���Y&\r�'c�n��^d T��N�A�J�䝓��_�\nl䘒`�R�2�s�f�^��y�9�AF�^S���\"�W��aY��D�ay��f��읣�xo?���:FqJ ��oX9b��E�M5Z�U��WiQP��S�p�SSo��'�(��qi=eIP*=�c\n	C(�,)��MK��	���\0�s˹�ҡ�����1�%d���C��}��d�20�����Gj-�<e'n��\"Q܉-D�PC��(-;�򥲡�����S����g�)o��¯�P�|���D��k.\0e�tn5�~����܉���]���C��x �B��ZPQ�Dl'��C	^ߒj��k}�'圜�<_�� f`���8�݃[72��>�n�� kg�yОi��ژ9K�����m4y��	��<At9n���{A�'X���6O����.�z\"u��n;b�h�H��]�#L�����O��V��\"7Ї���!����9�;�c��3?J���=��v_[�����<{^�m���%�8bI��#�U���Âw�\$Z��x]mQ��U�z�;��qT��f�p�J>���kؖ�>�I�I���{�`���\\@��Q�N6\$�n\0�8�2# @�7�N��d�~�~lt��'VL��7��5�J�#�'P6\"��~7y-j6�9���bp\\�0T��K�ak>:�R�pZ3L�c�H*B7�l�ưkH�f��\$|��haL�7�� �b\0�4���\0�'p��g�H,���\"p�\r�@	�l\$��b������\"4��h�v�B���|h\0�\0P�l�L�R����L��d��y�2��\0��~� �j�G'�ΐd}T��IQ'0� ��0|#0g�J\r��>'�\\|�y0t���M��A�4 �\"�&V��ЂqJ�*O���gR7��M�0���&�������q�Q��=�U/&�Q��lH��P���W�'��߬U1�1���Q=@�%m���D/�~��2�B��@�k�b��B�Zk+�dH�G��Y<r�?#J^�&~9�\"\"l��zY��e�\r��7�ftJ�'��\"�+0ñ�ߌR�����s0zލ�1l�8�I\r�ۑ���5��y�JnR'�'��+NVb͸�NH��\n����j�qI0w-2�\$�;+�A'l�Cz�2��G�/2�#/�LC��/�h�h@�L�G	�̤<ئ�<�F�3��1�,��2��3s.ѿU 2�-��\0@���9��5q2�w�7�Tm#�6R��B�A��>24/Ɗ\ndD(?��3,�-�\rs�^R�qM8�y:+3�K/�:�?6��S��5��*r�9cJ%s��H��(���r8�U���>�>�����.+3� ����P�q>T\0U���,R����F�^��*��?4&Q4+)��Q\\G R#��5���:a��2\$�Ggf=<�\0�1��o]���4f��j���)��hqFb5G�GF���^AO.h�2���fg.\rf�9�l24f��o.���G��5b�4Q�Lf���5L���Q�M\$�I��a@�c�(g���1�(��a�^���Fd�;DL�rq%&�\$��Gaf�Ϩ&��\n���p��>^g��R]M\rLOh�u<�t�d�TB5T��6-g.�NQب�d\"�/E:��{�`dNu�B�? g�2 �#�t/�x�K�l|Bd*L� �Ռ1 �3O�\$l��l��L ��|S�\"��L�-�J��(20^z���a��}@-��=\rm^�hV촃D}_U���(��&�R��_v	9U�^G7a�>�#�(PET�b4�nD�n-�`C�9�F�A�P�\$p��\"�����B�e��&�g��'J\"b�\r�Z3m\0�-�),:i�<�.=\0�C��(y��lg�_\r�lȓJ*�|��u�ˍ�`�h��l�y<'\$S �1����@I�@@";
			break;
		case"da":
			$g = "E9�Q��k5�NC�P�\\33AAD����eA�\"���o0�#cI�\\\n&�Mpci�� :IM���Js:0�#���s�B�S�\nNF��M�,��8�P�FY8�0��cA��n8����h(�r4��&�	�I7�S	�|l�I�FS%�o7l51�r������(�6�n7���13�/�)��@a:0��\n��]���t��e�����8��g:`�	���h���B\r�g�Л����)�0�3��h\n!��pQT�k7���WX�'\"h.��e9�<:�t�=�3��ȓ�.�@;)CbҜ)�X��bD��MB���*ZH��	8�:'����;M��<����9��\r�#j������EBp�:Ѡ�欑���)��+<!#\n#���C(��0�(��b���B��,��EP~��r&7�O�V:=j\0&8�\\b(!L�.74(��3# ڵ�C#���h+��#�� ˋ>�=C،�H�4\r�B0�/��9�`@S�Bz3��ˎ�t��d\$3�.��8^�����?�xD��jΌ-m��Ȧ2�x�!�N+0�cj2=@P������5���Ta��\"0;\r#(�\\�3R�Bp�ж�+�#�ܵ��2�2�!.�&��7��>*D��6����4�Z�i�*��(�0��cB;-��?jְ#\"�\0�)�(�dc����iӸ4�8�3I���/�ؑCx�?�¢��\r�ΑBC\$2@�a���`Z9�l�)�\"`Z5���v����]�(���e%7]��09�,�'�����3\\��q\0P��]�Կ�#k�9K\0P����7�l V�ű����w�M4�>ҍ�0ͮ��{�:�\"�����9(��U3d����u9�#8µ��[SC(P9�)8�3�:Z�Јb��#����_��JVeb����k����8�42I[l����6��[�Dҙ\$DRLȕJ���W�f�T�J�^(\"سCr��x�/Ş�PҌfiܦp�E�v4/�8T�2�4)Ȍ��NJJ�rmi�2��P�y:�@�Q�UOUb�V\n�;�D�Ar�Wp�'%�Vs�T���!8>A ��2D��a�YF|Іrt�2%YfJ3\n�0ps���4h�ڨ�p�u��>�\0 R���������aC<%~���)jUK�	ٱc�m<���9p1p2.����s~�����pN���@\$\0Z�%�>(@SI�%�C�jҙ��\"Ӫ\\�e.LΟ��Ki���=Ǽ\\�2q0'�%�vo�iQ#'�N3��ފ�Y�8)�:���\0�4�0�J����U2B��Q,%�}���O��aL�`7�\0o\\3�g�� sB��y.���\nP'��[��8����/��f���G�m:>'�Q��xS\n�A6M\nJB�9� ���5@CkVi�j�)��P�\\�'d��ґ\"n\$��qBVhkLq\rfH��A˙8H͡� �+�\0F\n�A�,�#�S�/������(\\s(��!K����@B�D!P\"�P@(L��3���H�0P_2�,&D�++-�r�\nd^IO��&��6/9�s.qF!5!�;��eon����&j\nb/�\"j�V��Z�EI�7\nh]�q�YE�4s���׈�&�¿�U&�`�\"Xu91&4�\r2�\$��j\\���ha�C����_�H���!i�u��d4��?6��[W\r�`�u��>�\"�%�\\��3\0]�m.�׈MQ�\$D����J���	d��ц)KvFa�3��m��|��y����o�lʢ�+���o�ru�����v^ϫ&4������k&�\"���\\��H��@�BH�џ^F)���G���P�g�z�>�;�\$ ��\0/*����X��1����cs\0�'��E�5Q�?9=t\"�@N�l�;�k��N�(ZpR��,P�Km�Q���h%��v����0ɬ�0Kڠm�a��.��DN;��o�)x���B��F���B�d�\rP	G�dʢ��C�L\0��a`�ͱ%l�8?Wߥ�s�ܤT�q����9AP�Z�_���C�6�u�@o�7�䟖r��Q��2��a����\\��s̍��5�C>n�Y�,�2�ϑ�;|�1cK)����j����\"�t���@��|�@_�?n�aϫ��@�QQp�s.���2SDh��͒0\n0�q\$@�xۇv������ތ�� r�6����pz/e8��O�y{��&�~�M�D~�̼�6��u/a��o/4^��=_���,����M��uYٛ;�\0��L~.��c��@~Xi����ϺYB�3�}�of�s���e��g	\r���d��_IŬ9A�[o�ۯ2@�\nfÞ���D�i3�r�J.l�͘���lO����TC�tb\n,�xdB�'��3�)���'j��4�b�%*oE��NFʌ�ܦ��z]Oj���[pt�O��|�ot�oH��d�|�oR�O����\$��ϐ��0y\nP���F��N�H\$��#B\r�C�6��\r�4k\$�[I2��	�*eT��\0�0����/v\\��p��Тn��x���o���\\D?Clf1�\r� bz��n\\Pl⚆�D�O*� �й�J)QB��ؽ�(VJ+�teFb0�qrD���;:\n���w1���,��Q����Q�EQ��fF0�	�>LQ�+�;�T@\r	����c40�\08I�i�)'&EQ�1i�\r�\$.MA��K�SNfܒ\0Q��Ar`�a�@,d�-������x�M�ܒ.�2�k�d8\r�V\rd\rmv������\"B��p	%�����p|��;��_�N�\r���s�t�r��\"�*K�Oz����PZ�1�12/bf��T7�PD+�~��%���4�,5X/��k�����tl��)�l�C�9��'�1FJ��nꮔB\"� /\$p�m�D���n�`+���s�E�0�\$�&m����c)21���1234/�&#\"��0�F��v��g�:��2l+>	���G�&�C��js�k0���\nBB��t��;�	5��)�0-��.਺����'�U\"s0��2����ƾ+�<e�L�>/�@�-�K�g;��f�,�Ԥi�F\".\r@";
			break;
		case"de":
			$g = "S4����@s4��S��%��pQ �\n6L�Sp��o��'C)�@f2�\r�s)�0a����i��i6�M�dd�b�\$RCI���[0��cI�� ��S:�y7�a��t\$�t��C��f4����(�e���*,t\n%�M�b���e6[�@���r��d��Qfa�&7���n9�ԇCіg/���* )aRA`��m+G;�=DY��:�֎Q���K\n�c\n|j�']�C�������\\�<,�:�\r٨U;Iz�d���g#��7%�_,�a�a#�\\��\n�p�7\r�:�Cx�\$k���6#zZ@�x�:����x�;�C\"f!1J*��n���.2:����8�QZ����,�\$	��0��0�s�ΎH�̀�K�Z��C\nT��m{����S��C�'��9\r`P�2��lº����-��AI��8 ф����\$�f&G�F�C�/0����\"�눡D����uB`�3� U.9������`�2\r�\n�p�CT�v1�ij7��c�0���\r{�aC�E225���иc0z+��9�Ax^;�r5X�p\\3���_f�2H^*!��)�p�'1�@�}1m���R��:C�z:��S:��b��;���K����&.���(�Y��F=B������C�H���d����I�ū��5>,8 ��xZ\$�N�M��;G1��B���l�A��(�@�z4�X�3��(Α�۔:�f6�J*�\$�@R��b����́�ϣ�ً%����@:O8�E;b���y�2\r�����8�N1t�׎��S����OL��c�۱��D�u�Եsh�6�1�����z�=x�8��'a�QT�\"N�O�kXل;j���cx�3\r��f �SP؍���t;+^@�{�c`�TU ���v؅��H��0pA-�ߑ�@��	P a4����Q< \$�6����� �1�w����?��P`o��=���\\\r`0@4A �	�C\naH#\0��1�XE�XL�H1� �|R2�T�<>�-���_�0��E(:p��@A�ֆD<Aү\\�̘�r�h��2IjU���[�}p�5d����#`��'u��x>;�\\��s��+�=���c3#a����P�kq�H��Hoѡ\"Nd�� Z��iOG�N\0�d�����j�u�����XG�\\�� e])��(	��>wa�������>�%�#\0��VI5�Y	�`�N[QO7 ����f�N�N2-�`���@P�M_6��Xs7����^��T!j�C���� ���s�RC1�V��_h�������BɓP g\r�#�t����9#C� %8�>�LKٱVg�x�C\"g��TқJrGAAQ �Y���h�d9\$�1�����}.���Qj\$�әMB�����E�|C��\0�)�8eh��|6��`�S���	U�����Y-v,�\n��(�}؂���M���x)��@ ��=%\"v�A\0F�VY����t�����CAH!f+��[7	m�^�޺��Vֈ�j����F/��qĨ��Hh\"R��ܙ�\0� -j���β��S�51p=My�l^�G(�\$��KP��\r��~���AoU�0�6�ʯb��+�4����\r�5���^'=D��F\n�@БrTF�!� q�5�a?�����\r�rf�Pdv�^*�\0ό	.A8P�T��P�r9z��0����bJR��5OB�hO���nOI�	��£ט��Dx���Wd�xg���3���k��p�����p��R0m\0袓�0J���P�O0\n\n�4��H��uͥ9��d�}J�0�ӊ�TZ������ط��7�\0�@\\pFd;6�.����Y:\rq:k�6K��g�>�GW�֝Ʋ�ʹ�BfMN��|&t��P落��ce�4�e��)\r:9Ա��l �Ai����!+\\�8���bwd�2&L*F�\\x)E%�W�f��Ѣ�*�B*\nhK]e�2s�7n�������M\0~�23:�%� �C	\0�8ɣfn�kB��\r��JK}�E\n�)�W��\"mf���.��Y;4 l��#6��A0 ���x\roOS���#���	��%�>�dz�a�}����̂^�4/0%ʆ����Wr�Ӣ�>�֢�o%q�������~�v�<Se�>;�y���O�ԃ��g]�'[M<[nABsƐ�\\�Γ	3i��H�z��)d�_T#m�La�\$֩)���h�Y�	�2��fÜ�]G(<�ql�:�#R����Ύz�&\0�;L��;(w�W02�dS��'F�\$����\$��c��#d�٣�-v �\n�o�+p�p�nX0,��jR�܃�9�\\��VM\$i��jjGlĨA �NB�dr���5�L0�bm,��\n���l1F�e\"�wM�݂Y�<�����g���\0@\0��\0R�����ͯ�t,�^�%-�(��z���0��p�c��3��/�����WkP\r��zP��c��h����\nN@�P�� ��O������&@�O��x�1�6��&�	r�MV�B0ߣh'p�ϐ����,kp���L\r�P%QT0j�0���dc��\r�0\0�C����z#�>6<HBS��E� #ZBj\0U��K�-_�/@A	\0�F��D�Z�\n����\r��G|��a��loGM��T�B��=Cb@�b�\0��n��!�(͌��F'����'Z1�hs�5#R,;��\$\"�\$r�N�rU�%�D�P�\$\\�P�>�SC�#`	J,M�І�Ph�@���p1�0�2I�)�5q\r�?*���x��k���jр�ۏ�,2�p�+g�\n\r�ϩ'#	pZ#d�\nC\"`�l�K&\\��j#���:���R�o�5-P�/�G1W\",�1�\0ݦA2S.y��ܡ1�+Rc3�[,2�#ǖ�.:�[\$��50R!J��_4�6nVsI6�g3�[F�SrP䂚�+5R+*FFD�6Y9nS9�m+�f	!`�*�B1��#�\n��E&��^�,e|���\r�2,�<��������bf	g�n���k�ɥ6��;N�%4\r#L'qF�hf\r�W?�j�0�����Nl\0\$�`��FѺN`�\n���p4�މEt6�&n�3V��#=�@Fqj#�c@�q(���v��\$���>2m��#R�pm���n�3��紿�*tcr6)I��\$'C\"Z��REH�#'�T,@R\nn-��FvL�P:�0�M�#�o��W@Pa�q�H0#N��v�̰�/�#� uO�aN�\\�О�YO��Q�#��G%c6�#�\"r�kS��U��pB/m\0(�|)m�#`�U��M�`\$�f0�\r\r\00031BM�&`���SM���tQ��-�#<�RC�؅�CN�IO&\r����ivc�,S�P(����Ka\\5�r���޿\0�D�2�P�c��� }O�%�0#�I7�/b";
			break;
		case"el":
			$g = "�J����=�Z� �&r͜�g�Y�{=;	E�30��\ng%!��F��3�,�̙i��`��d�L��I�s��9e'�A��='���\nH|�x�V�e�H56�@TБ:�hΧ�g;B�=\\EPTD\r�d�.g2�MF2A�V2i�q+��Nd*S:�d�[h�ڲ�G%����..YJ�#!��j6�2�>h\n�QQ34d�%Y_���\\Rk�_��U�[\n��OW�x�:�X� +�\\�g��+�[J��y��\"���Eb�w1uXK;r���h���s3�D6%������`�Y�J�F((zlܦ&s�/�����2��/%�A�[�7���[��JX�	�đ�Kں��m늕!iBdABpT20�:�%�#���q\\�5)��*@I����\$Ф���6�>�r��ϼ�gfy�/.J��?�*��X�7��p@2�C��9)B �:#�9��\0�7���A5����8�\n8Oc��9��)A\"�\\=.��Q��Z䧾P侪�ڝ*���\0���\\N��J�(�*k[°�b��(l���1Q#\nM)ƥ��l��h�ʪ�Ft�.KM@�\$��@Jyn��Ѽ�/J��`���3N�����B���z�,/���H�<���Nsx�~_�����2�Ø�7�)6�T��`gvN+o��M��Ϫ�� �;񋦫�g6vv6�N��X���\$\$���n���^�������g��qO�i6��*�0�2\r�H�8O�BP�E#�@��pϰOӼ�=ϣ��:\rx�B�!9�ԀX���9�0z\r��8a�^��h\\0ꚴ�Nc8_����9�xD��l�>��4�6��x��|߲K�v��\"\\���z�\$����g�}�Od>/��S��R�����y��\n��\\9/�v<N��2z�9���,�B��9\rڰΏ�� @18X������of�E#>l]���j�ˑ�ZFD����[b�Coi޻�N�)�D�=���\0v)q#�@���UH�p��z��ȸ�̐�!4\n-��Ђ�H�¥�Rˡ�.L�!A6�)����i��ը�ZB4�AW���!9E�\"Gx3���\"�t���uqY�fMuƀ@	\$*���)��HbD>�j/�\$*�|0���=���Fs7\$*�B=t�^q(�5���.H����h�p�I'��c�J9%����Ÿh��d&�X�&`I�������-œ8gd�ܖX8���B�}��{�!����:\"@\$��J,����Ȳ hdᢽ��ϙ�sA�N��\$�1a%*��3�ё2�Y�R\n�б�bӉ�4h& ���A�1Y�a�-	H�:�u�I�kp	�S�����Yg�.�*5�v�\r�^y3�6��\$�j4��SKC����AE]� �¥�bD��7�j���ІF�Ld��ĺ��{�&�q��jvd�C� ����2�H�w��\\R��h)�A:`��el�M��p���a���7�@���p�ĸ��{���P99g0��tuNxY�Rٝc�0�]VGpuK�Q�襽�Į���^����J�W�! X�\"�LY�ʉ�P�3���؂g�8'�C�q�9�W�&�\\�nr�)�0� �pIH�P�R��ݡ�Ld,}]�?PEI����*�)*��ƕ�L;g��/�)b8�J�i3\$C�5������p��c%3%�I\\B}l6i��c�O��8W`�_�a�.��0�؛ f��6��ձ3o\r\0��'����\0cp7Y����6f֔i�H�q�?*՘B��Qb�@*��a2!7�O�}cR)��[́@\$\0@\n)v瀤=�r�IYi;��r�؃Wvi�d@�݃�i��~�|`ݔR�_J7�LP�1�� �d��:B��%v4�C��,qpt�	��5��@Ⱥ�7�ݔj�s��4�ǐڨgp��\"b�k�e0����(]�ҧ*%Ŋ�Z�>H���+o)C����!Efb1H�0���7e�LE�p�E�0���TAUIC�&U����b-�񫹄�ppA_�(5n��Z��&��ը���GfJv�w�JQ)�B�8 \n<)�I�'	<hv�/u�F��>�ڇÞ3{�*�}q�����4C�ܐ4��xI�/��\r�g���D��G�fb�o�&m��\"A\0F\n���#��\n��4�\$8�u���{�;dNV1Q\\o��Z����.\\�H�V:�!�D��ZD��-�:�Fsb~E\$	!䄏�֑v	��3�@���#��R�/���&Ǫ�k���^���x�r�_*Gq���V��i����mŔ�{��7O5��ۉ�=�6���臨~�������u#�2\n�K�)�(����۲˖���C���Mf*'j�/���X\"��*L�\0o2��]%�8�<�����'��*��ˮ�I�8�\$���4�r{@t�N� ��D�BIi�-l����Lh��{�f5el#�N{�D���Ā��lJ&.�\r�\$b���ڄ*�M�/+�f����2����\"���KA���W����E	��Ynwg��Dx(��P��BRp�E�.)��窼�������&a\$�F[�d���(�'������	/)\0�o(���F��B*��/�5\nJЋ�j�I�E��7	���昸�F�i���I�  �T�i��\" -��\$T�b7P���>���Ft��O\0�G\0Ⱥ�Z�Š@�\n�� �	\0@ �N\0�P&�p\r8P�lk��ae\"�����ۤ�-��(j\0^2~L�+�X~��V��*	DW#�\\���lય�cd0\$��J��+�z���7� dt\"���RER\r'ě�G!��\"!�\"r*�b��4�/�#�&�,�D�<|�E�;1V�G��ɽ*,�\"W�\$��\$�l�Ȅ��r9%��J2�G�(���06/g�* �W&��+��1z�ŢRe��%�!p��R	+�	b��\\WI�\0�t��r���b���[�\\ N�r�E��R�N=l>F,��~wFH�c'�(j*��2�B�d���R��F�!/�xc��T.85�'l�2H�2Ř�h��Ⱦ|N���'P��Il\nd�@/b|�z��-�����4B�䆒�b�8S	1Ð!H�F���J�x�\0G�A9��!G<��E��p�)�-=�k>0��Ң�R/#�(����@�k�^��� �C�A\$\n=/�+qz�DB�BBG�B�\\1�q�VA�67�\n��t��{Bh�[�ܞ��,����\n`U�tF\0�N@�@~��:ڞ�B�����T�b�It� �2����<�*��0��5&�F����l�]���fL�L�,��-@SI�`[\"L��D��(�48�i�N��(Om��>� \\�goDi6:3�O/H��v��3D��?h�IHes�N�E*D	�.tE\0�G�S�%R�>��-K��RS���5q\"��?Ē.r%2�P!k%�K&\"G&s�&��\$�V��V�}(��%UyW§X3\"j� �uT鼖�1\r, ,�,���J��OM\$q.-�wu���1U��U��]U�]��9o\r\\Sgu��ID�J��B�.��+1�n���K\"����݌\n�FH�O���	4�t�!�[\r�*D��'�sd�N%����'�MV\"5�\\V.=�'e64�3��U��M���O_/�5����]At�bQr����\$��+`�f����ǢxNw^t�^�K`�i\r��U�>t�Rs�k��(vTVK�_I5ni;lֺ�t�.��&km55]!���Kt/0��^�p�q4C\r)s\0�m��R�Mr�C�r��,�tԷBb+�0��/u����Ed��k��\\#�-�W5�\0¨�?6�Y\"�Yt�A�	R��V�����q��TՑ���UCuGq��K��s����HE�{�����J�=B��|WEnW�.hP+TI�n�+�A}g<�\n��d�0�Nr,t�d0��J�P�\"B��3y1<��N��WKz��t��l��vj?��<7�U��yQU�\r|�;������]�GM�8?����T&x�7�\\�#�\"��w'�4K��qw���yO��݆VA��:�D��x���[X�COoUp�B�ψاh�8�QV	��Ʌ-�0be��}��oqux���B\$\\��|w>�4:e��cxy����M��e�G��`��F\\�r��r�����l8Í1�z�nc��=6K��h�\"���|Ȁ[���6�r�Ⱥ8��\$L��,�e,9hEylbņ�(����Z�4eH�YZ��K;Y\0�u�#�\",8�?��+,�\"�eZ�z~S�=���\$>ҦT�����`�\r��\rrnT��GT�s�Qy��2�sU�?#�)N�3�PW�H��ܵ3\0C�d>ȧ�\$l\n���Z��='&�\"@s�9�#����-�\nGo�'blϤp%�C���o����E�>��O���d�ΰL�tb������uZ�6 �J.R���S��Z.b�.nߟ���\0���t�0�L�u��ڦ�MD����hi���@��N�&�WV<LR�C3�E�j��0Qv,��C��trݓ�f�S�\"v�;�����>�\"�	�;Y�(��`�tupt����zo�9\rmsߴ���BF�\\'�z������{M�]�\$<G1Ol��J�R.�p?3���g���7��[?�OzS��FO{M�i���:��;���ue�ϻGuh�(��f<zEJň�-͚��2RU����#���JE��n.9��Y��Z�Az��r�d#\$�0)��:6�Ӟ��P�P��\"�@ߛG���\r��N\0��&��<�8@��L�и��.Y���k�=	l;��SB�ECQf�X";
			break;
		case"es":
			$g = "�_�NgF�@s2�Χ#x�%��pQ8� 2��y��b6D�lp�t0�����h4����QY(6�Xk��\nx�E̒)t�e�	Nd)�\n�r��b�蹖�2�\0���d3\rF�q��n4��U@Q��i3�L&ȭV�t2�����4&�̆�1��)L�(N\"-��DˌM�Q��v�U#v�Bg����S���x��#W�Ўu��@���R <�f�q�Ӹ�pr�q�߼�n�3t\"O��B�7��(������%�vI��� ���U7�{є�9M��	���9�J�: �bM��;��\"h(-�\0�ϭ�`@:���0�\n@6/̂��.#R�)�ʊ�8�4�	��0�p�*\r(�4���C��\$�\\.9�**a�Ck쎁B0ʗÎз P��H���P�:F[*������\nPA�3:E5B3R���#0&F	@�0#�#?��<�O�ئ�4�sv�Ȯx��L�w*�O�;\0005�`�7�#s��%N�9RE�� ��j��C�|7�� ���ƌ��R[��\nD;�#��:���9�pl,C�C3��:����x�m�ѥT7>�r�3���_c�#���JP|6���3-�ˌ��x�&��`�<��QDcK�>#������ʬ°�SJ��,�7�'�*�-2��+�+B�=�� @1+�����2Q�`�6���9�K�*S#	#p��IN*.0؏R\n�8`P�2�c��˞C�2�@�:��-�=�L�i&Q�k4�e�<�9�*��T�ݨc�o�;�(<UN�6�X#�]/�����f�&�ɼ܃��������(��U᮷qZe�bx�UJ�T��cx��8�/X��7��`2�hn���}-A�3ؠ�4�LK=�)*ܔ7b(���ˎ��}�В`�!&��w*���.j��4�%)�3�%�>�\"T�#�m<*\r���78;����fj�}N�慓�!�0����Yr�X��0RM�k2A)� �u�<�8\0��CcYWe�қ��GU�R�z �՚3;�e��z\\�K5���*J~�x���j�� U|�!eDG�*Y�ug���V��[a�n��V~W�\r����Ļ�m8ũ|��h�߫n8Hц�@�\n&L-���8� 4�72d`�x%K�.� I�A��-�����[in-�θ���\\�̼�XֻC�>y!�����A�i#I)a#T	�\$h �9��~�(b2De���i�~#H��?F�FbYDa͈,\0�K&Q>��%2�����\"�^�f��\rŹ�p���\r%���<peb\$~�T�8���\"��\\�\0�8oz����\nJA �9���H\n�@\r˂m���hɋ�5���`-��;��h�!���\\1Ȥ6��s\"��t�J&Ɍ\$djC��o��\r��b�%Ypw&�`���Q�hb���n`� �g�#I�O�%\$F�\$	��X1��@�H\$\"�%�o3\$���6�X50V���K�c� hH�إ�*�%ꞑ��l���A�<)�Hc\\��l��ſ��	R�d��ä\"pN��k%���&j91�Q7R�=�D��ִ/-}nC���6���`�D-q#yD�a�C�c��?,��X��{8h���0�vC\n�V����B���'� ���mU)_6v���\n���(�/c8�Ň�@Å�D͐Ř�v`oQ->��b��CQ�&Ǖ\r��QO�0����0��M1�;uP�2�E�4��EI���n�8v����4��ý2������r{ D���c�K�JR�]�B*r��T\n=!�D\nV!OL�DE���Z�1�=�}!�7z� ��/U�\$,9-�<��^�C���G�i�>�퀜��vø\n_�cE�0�kj�.���Ŭ��u.�L��sؓ�1\r�H�>H�z6L�t��}bq,%Tq�EMCu�\$A�b���w��I��L����9�;�0\"����۫zF���B�T�! ;r�j_M�V(��bj}��,��'�F���(!���h�L�ofl��2d��R#WE�01��\\�����\$�3Tv��O �<���H��*�ܳ�#�hc�J:#飅�S~ʃ:H����C�hB)y�(r둎Iɐ�EǤ����[\n!���b5ֹu�)�]�7�ʁ`wy�f�#�,�Xa��ԧ�e����\$C�L�懎��-�\$�b�ܔEy%T�1K�k�\r�A�Kslӓg��##���DQ��gᛄ���K{Q��M朶:`�c\$|EW#(H��+^�����ɓT>ْG�J�~�?��#]����Ϙ��qZ��V//��h�R_��m�\"%�¤���C~I���Ɍ���%&��/�^\$��\rp��`�l�0g�D��V�gFxC�P��àR��J̪�+�������xd1���O��S�pJ�ɀcMj��{���~wM5�v�'pC���t	�R�ê�n���N�:!�x��H�. �P����8�C/\n/�3\0����]PW-�d7o����.�v�l	�B��*�\"��b�8&�o�B�:�f���^�G �B�\$^ i2CH��p#F\$J��p���HP�\"�>Τ�l�m�.�'����FP�qC�g��Pm|-��֣v؍���(F�V%��Ϲ���0m�|���b��J���pr��u�0�)�ܤ�ύA�L�qq������D�-&p��%��\$�B��0Dc��̸9M����t���UQ�f8�������i�l*��m� öiL�zj�l�r̦4r&0rqpw����H�\$P�Kq�O�%FB�1��2W&R���\"\\!j�r.;%��\$q�O�}�ڳQ'�g�ڭ�/؇R�٥�*�a*R�!/'C*��qu,r�+Gpg��9��D��!R�'����u.��&��/����.JD���q�7fi\"L�R�\ns��S�K���e�\$O�P.���.%gq	��f�s@��a4p�2��L\0�jz0�\"�̊�b�B2�#lH^&���Hn�i��\n���q��0b�&�Rd��\$�'4���j\\���H:�o �l���8�1n/�Ȯ����)c�8�ȩ�j/-�w��#j�T�r�T)캓(Sj�^?�4F����\nS��I�(3��/���hK��f�i�*�6Φ���cJIb��&=�08i0�\rZ�2�����B#C<�i�2J\$8�TN���#C�b��J�0uǲ���D�O�vpl8p̠ut�p�\$P 0�� J�.C����:��@�gl>qqrCf��J!��7d�*Cv�i���\\Me\"w�[H�[�E#v\r�����2��,H���>�X^P:�\"l�	\0�@�	�t\n`�";
			break;
		case"et":
			$g = "K0���a�� 5�M�C)�~\n��fa�F0�M��\ry9�&!��\n2�IIن��cf�p(�a5��3#t����ΧS��%9�����p���N�S\$�X\nFC1��l7AGH��\n7��&xT��\n*LP�|� ���j��\n)�NfS����9��f\\U}:���Rɼ� 4Nғq�Uj;F��| ��:�/�II�����R��7���a�ýa�����t��p���Aߚ�'#<�{�Л��]���a��	��U7�sp��r9Zf�C�)2��ӤWR��O����c�ҽ�	����jx����2�n�v)\nZ�ގ�~2�,X��#j*D(�2<�p��,��<1E`P�:��Ԡ���88#(��!jD0�`P���#�+%��	��JAH#��x���R�\"0K� KK�7L�J���SC�<5�rt7�ɨ�F�\n/��\nL7��<�)��ܜ�E��ܓ,�K�S��@\$h��7�����BS��:�<�����.�N/��B�Ä\0��#��'N�@ߵk�����V�T	,�`@7�@�2���D4���9�Ax^;ہrH�=�r�3��_�6@^)�ڴ�(P̴����<�x�&��F�1���8*�~¨�Z��,�j�߲I �����\"����7��a���@T�9��H�5�P�&���,����l:,���.�<8;���70�m*�K��6?��\nH@P�h#��2C`떻��/�S���j��	�t2CF&�%���[2�룠(\r#H��	�x�\r#X֣.\r������M����0������+yk,ԋecn�'�lؾc���2�;~6�\"�E���=��j%+���\0��\r�Q�J�j4z\$��J�Ϥ�����.OL :���w^���Z��ʲ�jR7��26��T�8��c|�P�+^�v��\\f�^�vYI�\0�FOi\nC\n��`�\n�)6��/R�S\nAe 6�{IZ*0Ƒ�/G���R�8/�?e�GE�n'��\"v�NA�N%ς\0����rYA�<��Va�Y�Ei�U��V��[�qE��y�M��<.�}���_+��+���I��HJ��hl~а���@��)5&���eҁӘppD,��֒�Z�am-�B�\\q}r�D(���`��\n�äk��/���A�;�x����޽I�H��&7��)�\$�S��:}J�>%*�2Ղ�s���!%�C1�N%\n����l���7\"*R� k<�4��L��5�@����FP�d;�D�BJ�:4dpӱ9�AH\n�	�YaR�H�@(!��z�⺖!��#I/۹0@��+��ü�z�x5����LsߥAQ�,�h@�:V����������Dr��A�-kQ�����t�'�z��[��Wa�!��\na�ԍA0��52�t�A\$��,	)����ZF�Ì0?����؍&S�>=��=:�?�A5\n<)�@[L�c��������ԃ�b�\rp�*�)�+��²��?ZIPh\0��� �e+{�=��=L3~�8 \nnj �&�;�\0F\n�-��G���{��V~ٔ�K҉.� ���S�:��-AHܘ�o	�8P�T���@�-�I��˨�N��l�L��)��\\Y_�̪2d�p!�mm�: �>a	[u���ߓ\"E�H+���6���Լ�vL	ړU,�\"tq=��ŵ�w�:�&Dr�;VL�^�#�\r�����V�� pL4�Z����M�)��t�R\rڄе�+��O)@@��^��\n�~���A��o.9����h�т���фzwa��\npp�������a�Sj���A�e�=�G�[�I�D(�ۛ�C	�3Aľ�)j�vy���-j�/g����T��8(L%��\$��IV���*@�B8G�I-9�xN��k���5b.��<P�}0�X��y��\"�`���SKX���s��3��!P �0�+�\$4���+����*s�%ϔcܮM)���@���A�j���+�_��FYA�����A�J+�h���\\��	TC�՜�\r���3\"&G�5�SCX&K8��x�T.S�yg.`Մ�s����9�>!܋�6Gpy!\$d���dVJj�H�0�b�\0H�∫���tk���>a碐4��~�KxP�%�L�JI�l,@������k�ѿ�S2n5)%�\$��a\r�|;*u�1ϙ��|O�A-�2��9�+/	��f����.;�Nd�\r�����b���/�r~��5���߲#�س�U2��)iў�}t�v�V>!�4�\$�t�R)7�d�k�ʗֿ��(\nC���~�'VF�z���O�}���H�ti��h���ېQ\"�QFKA:�nGj�X�L��'�ą3\0j?�<G)\n�.`/o�\0�h��Lx�~w&w�8�B��r�Hz|�6d��^��\ng�w�N�On�PW�MoZ/�`�|/�ǭ�˼���&�T�)��d���B9��xJ�����t1Р?�\\!����R����B%	D���X��'E�3c�*�l�B�D)D��H��&Q+ �)YP���:�^ri�.I��#���0��R��t4\$V��c%�u��^��	��,�>�Z�/��Pk�~;e�bD�b�00^kp�,e�*b�3nX�p�1c�+\rn5\r�b1�20\r�R��b��x�K\r�ѫ�M0�1���*\"��yвmp����\r����f��\0�%�<\0��q������y��\np��L|ڤ�PS��/��q��y���\"��c��&��%Q�3�7!��b���\$���^��}#��.(��B\$�!Ѩ瀕'�=�K(gqR1\$b�\"�{2�h\$d�Q�!�\n�(�-\$�bhrV3Һ�MX��vg��(#-t����1��x�i�-r�+Q��L���-�Q�.r�׀P�̀�M�R��ѰE�(7ҫ(/JQ�²�)Pp�\$�20(:x	\r\\,��\0� &���&�xg^�ðy&���#5\0\\,*P䣒6��bf�eSk\0�����h�����b�	��6�Te�W	M�����Ð0Q\"d�\r�V\rbfd�!���Ѿ?���@�\n���pMh�\$��&�J@�#�r�M���k�f��h/#'Bl������ڀ������Ӵ�(��B�� �~��]�lW�n\$�>d��nNZ#��pe���>�LkL6�3wG(͒*����e����v��´Q���*�OGp�!\0ޘI\nlgH��1���\$� C23j�B�x\$�D��1�\"5�Xm�ޥ��'�9IJ��(��\0�Z%/��*��B9O'_�<�\"����Mum��\$�~,��&O�m��O� �6�̲�GԀԇI#L)��ǚ<'JJ\r���5�z/�b0m�\r�n�%*7�lD���^+�x��	\0�@�	�t\n`�";
			break;
		case"fa":
			$g = "�B����6P텛aT�F6��(J.��0Se�SěaQ\n��\$6�Ma+X�!(A������t�^.�2�[\"S��-�\\�J���)Cfh��!(i�2o	D6��\n�sRXĨ\0Sm`ۘ��k6�Ѷ�m��kv�ᶹ6�	�C!Z�Q�dJɊ�X��+<NCiW�Q�Mb\"����*�5o#�d�v\\��%�ZA���#��g+���>m�c���[��P�vr��s��\r�ZU��s��/��H�r���%�)�NƓq�GXU�+)6\r��*��<�7\rcp�;��\0�9Cx���0�C�2� �2�a:#c��8AP��	c�2+d\"�����%e�_!�y�!m��*�Tڤ%Br� ��9�j�����S&�%hiT�-%���,:ɤ%�@�5�Qb�<̳^�&	�\\�z���\" �7�2��J�&Y�� �9�d(��T7P43CP�(�:�p�4���R��HR@���\nҤl�ƨ�,����b���#�鼩5D�ƌ�Z�V3�C�U\n�^�2zK3 ���2\r�d\n���7��@0�c1I���+B�(;�#��7����Dc�K��\0ys���3��:����x���\r�eApP��!}�u�C ^(a��B�`�\r�u(7�x�9Q����6W]��3d�\$�jB��������3M�<�\$�k�ᐌ	D��U3�W��P�0�Cs�3��(��geP�j�%@�8o�����½\"%l��>��z�I�d��2Hl��b�����} \$����[~��;)2DB:��3S��\n��S0��*�B0�\"����T��z�+��+��6�s�Y��F���nп5@)�\"c�\$%�,�u.��<;1��Z�εs���X�e�Fd��짨��)A�����FVꇞ�9�\"���O].8�7���)�����2�|�ա]|���2�����&\r鑸\0��l6Ȓ�\"�M��I���Ò`_��X	���n�Lx�#ĥ��H�aBjf8AaC�4D��\"�BoR�7�\$�(HWK<(8p�AB�>m��s�b��i\r���)�^3ȂW`�C\naH#\0��Z��\$�9H���p.XfN�`CE�2v0|��3���D\$����J���jAP4\0�X�r�lp@��Hn@�1�U&Z��y�U�W��_�݀�94�C�a(YDF6����cG����ҲRFf���nW��0`��x�Xc��5�@ؼ�~`V	�& �G�VN��6�J9+�x���^�z/e���`\nL�p\\��@na\n=H�5*�؋t'o�;�!/A�~0��X5:J��F�����_d} ���C��JF��b�N���R1\n-Il�A�\r��\$(<�\r����̤\$�s�Uk�`�M`o粘���BP�5�(t�!�\$@��L�����18�\\�Y�hи�6�l�\"@P	Ba�j2�(�1�\$�0R�q��0p��o5���A�[-�κ�i=j3��ЈP�CA�sS4O\n�����qY	�U�UE�/ Af�8sDkZנU��Cpp\\��\"fLC@iu=d�u�MP�����JS��IK)��4&VNL��8��ʹ�R��S1N�:S��izj���4W\"\r-Mg�0����^A�:��8�Hm��e�t\n�J�i�[�d�2�����M��T�l�0��2j	B�3<G	�Lc��BG\$���#4\\R�I'��r����{��7�P�#��q\"J+����8M�6,���U°�+��q�M�*��[	�e����RY����괟)�= �u�1i�ӊ�l�xNT(@�.p�A\"����ʥ�mq�V%ME�J�M	����(;uնs?CșS�\"?D~���	^!��fps���^u'��j�t�0�8�n�2�������	+\rX d;đG��]]�u�({_c�풞a�&g��^A��:Jlɋc�֊�\rġB�T؉�*�ֽ�@���ƱY+\r�ʲ���\r��g[��Z?͹�������#��IGz�&���ڼ�g�@��`L5��LR����N��)���;f�l:`O�e9�lo����\\�w��w�(϶w4Y`�d�9�T��j5|vSzP�t���])?No}b�a���L�NjO���>z	f��v�qŬ��*��@�-;]}P� ����tuӹa� �50^[\"��\$m^����H/H6�7H���H[�&r�����FVUQ ��LNXM]a��L�5�!��!�����g�O�D�&v��yșy	��/��k��;[N�H����Q!�e�(C���[��3�sͦg�.���Ub�[�;���	�r�k߻�MP��׈�ysj!\"W�&� ^⍂�M�S�����-,*'J����\0��d�ƼNJg���9G�t�v;h��\nt͖?�2�0'n��Br\"<d�8��&��@�A �H�~ߣJ�dt(x2cMK�OBl�O�UpXӇB{�P\"NfG#r�'��������F�F�@\r&�S�>٭`�|f�����el��Ї���B�~mn�P�׮`80I��|͞���D�����I@�������%q˧����\$��~��K��n�%�\0hd�l�t纺p2.��e-�i��x)Ͱ%qU��{I4daOkd���51�т#�ң��\rB%C,:�Q�S&���B?\$a���p����Q��\nN�7�?�*M�3�|駈�dl�H��ю�P�eQ�mq��L��{Q���m���L��PI���r\"�1!!� Q�zr.���\".��20?��db��Я�I�\$D����C�p�������Ԑf�@��;\"��҄��\n��9�D{�o(��.N\\LM�ғD�<�C��*N�T0�%���g�؍,k���9R�rG�k*-)p���+rG/2м2��P�r\r.�x���-24�C&pN��2\rm������#1�w0R����)�1	�J\$�#�6G1\$�@mҾ���5Lc�:��S	��5��3PJޱ��\$�J�\$���4��' �tħ�s�\r�OQP1��72`�Q���`t��Bpkg\0S�7�^��!\0n\$1r����������.��:md��̴�䪠�@�l�@�T�� Pd��&g�H��\n���pj�<�/Z�2˩�o1��3K���mL����!bq@jF�/�0��\"T mtۓb�b!'X �\ntY\0�Ff��\r�I���?B��H�BM�2�nʪ8��V��@\$ø�gq5�|�̨�-rh�AD6�Vqe^,�b�*�ФUL�V���4�Ѹ؍FӰ�t�M&���ݐ�PU��!�D����~����u\r\nLK n<�n�p��5daL[P0X,&�чJ8�zt�7NR)afw?CmK�j�S�V�r{r�w�Q*\nx\$�G�Z1O���W'U&C�ѕS�a9'�*4�8�B��܋QN�r�T�C�oO����\r��@��%!K����ؐz�3JM�4��~�8";
			break;
		case"fi":
			$g = "O6N��x��a9L#�P�\\33`����d7�Ά���i��&H��\$:GNa��l4�e�p(�u:��&蔲`t:DH�b4o�A����B��b��v?K������d3\rF�q��t<�\rL5 *Xk:��+d��nd����j0�I�ZA��a\r';e�� �K�jI�Nw}�G��\r,�k2�h����@Ʃ(vå��a��p1I��݈*mM�qza��M�C^�m��v���;��c�㞄凃�����P�F����K�u�ҡ��t2£s�1��e�ţxo}Z�:���L9�-�f��S\\5\r�Jv)�jL0�M��5�nKf�(�ږ�3���9����0`���KPR2i��<�\r8'���\n\r+�9��\0�ϱvԧN��+D� #��zd:'LC�\r\\\\a���\\�5��S,��im.'��*ݎ��B�j&@\n_	K`�\n�Ix��\n	b\\�/C���)�қ%�\n�?JD\n�<��`2�P��6I��<�c�\\5�4�D��� ��C�93J\0\rMB�(�\$���\0�6!I�	��Y,��\n��M\0�W�:4C(��CB�8a�^��\\��˘\\7�C8^���\\H;� ^)��ֶ\r�Xx�!�j+%�;�%@�-�N�@݌�S�#�r�5�3�������1�ڽ�P\0�Gm<.ꎈh�׎è�iNZ�\nh@��\"��i��d���E)0��4�q�� Sj;\r�::�P��\rj\$X ��=�3�LYM�3?R%�P�\n4��9�*�Qb�(��Od�j(�g�Ɇ�jE��/�J��PN��\n\"`Z�g��܃�	K��1�;\\�t��'��1,%�0�*�B���@�ϴ<R���&F�q�ج���\n�[��1:��#�����X�3P�(Z�@q+�R��0/��4�5��ܪթH�\r�K��Lpˤ�\r�%L��\nt�K�%�RH��'�+�`s�A���d�I�|����<��c�\r����#R�^�,<��@z��H�(�X\nSY\\	4P,���f�)�&m0��0-nd�\"�\\al>�ƈh�&j�7P����{��%!��F��i&��ӑ��{�\"	=oEV.Rt[;P4�Ei�U��V��[�;�5Z]���]+�7�0m�ԅK�2���k�1j\$EsV)��_��\$��AH8n>���G�^�B��l��\$F|�-Xj8�tBG��\$\$��X���[h:-ż��	u.���nC%1y�P��M	)�@�8�Ԧ�! :�ɼ��PʴT�;143'\$���m/�Xi��-�E��<�#�;��q���h�gD./��eC�;����2�T9l2e6!�,Gal/&��&�t��4�}Y4԰@PBT�Q��AN*�[у���2\$�`(,���]�(\$��\"PCHhA��t'j������F[�2~PL��*��Nw��99%�Vu.e�X3*�[S�@t����u�r����1�v�%��m(Eܘ�cœѮ\$������Lm<�'j��Љ�*��C�%ش�'�.� �Ǡ�\nڃ�Yjs|���@xS\n����H]��w���0W>��@s�Dv���Apf\r!���&��P�{AZI�V\nD��\nnE��O0T\n\0�h8�jY\$\"V!��bVKIy1%䦱6���>e\$�6��p \n�@\"�Z^�&\\.�U'���\0�uҚI�E��D�(d�	�3TuI��&ϐ9\\�Ad��2ʗ(�&��K�Wi���\0�J���@�!�C�O�\n�jl\r�d��R?���TH��Ӥ~��E~b.SL'Li���W��@���������[3�Nwk4���Nb6�՞���Xk\0'�es���N��X>S�\$��b�Y�6*c���	!����R�����ɘ�����a�{��E��@����Vb�VŗD�g\$42w�]Z���G�D�\rj!J��lnIZ�G9�\"���1�X*��R6օ����d�ʠ%��r�wk�@,S>Ws�x e@�Ȇ�^�����A�<���aL���C�[��@HK�|v�@�C\"�ܓ�rbwH������P�i�|�6����ǹt輬�rڠeh	�1\r�u.ji�5�����R��/���No72����\\�yA`d��.�Y�����{q3#��W�44�%| 5��F��i�\n|�M��-��(*\r�O�::��Vƣ]�O�cƁ ���pZi9��'ì���{/��&��s��P���c�{\0���(��I��U=�*. �eS�S�W�(E2&�L����O���u��\nMA��~w�QN!�>i�9�Z\\�e?��}�J,�z�������8�Mlg@�g�jaDj(\$�\$n�L�xj�S̮���,�ʬH���piX��5��/�0&tP*�K���O����0��A�{�1���pD	cD��ܧ�K0��nB�.f��*��ܐ|�0��В�p���D��O@��.�0��+6����[\r�DlHjﮉ!H�@ZH\"�O�f�@\$i,(\"@-���Zˤg\0�Ҏa�l8�>C\$�R�B:'o�\$|�ŎA����L�BR@��=c�gQ ���\rm�p��ce2؃��{O:�m��{&�d5O�0&�o0J��2�\rT���-ҢP��/��\0��Bp�i-�0N0GJ��'Rp�Uh�d�&	��i�&�&���Q��%��P�����pd����ѥ����Ϯ�\0�k�9Mp�\"�z�� ��kQ�V�SrťT�5\0�o\"\\�I�p���#����\$�M\$H)�2��\rr>���g&�2g&v\$x���\n�8\$��qdk&�U)�M���1�|������tڭ�\r�&1��r����uM�*��\$����DZ�M�5Rp~L�4�ѧ.H�.�5R���6c��� �Cv���\r�er#(\\�(�.Qz��)1��\$���Ɖtn�HdP;�3#��0��ht\0�Ȩ�Q4��5&BU/7@�J��cn[�D���8GK�*��ʼ\$dE�E�\n��	�0��{P�4�e�:r[:�|�cb?�v(\"jg;bl��ƃ�0�FPș=/X\$\$ۅH5�8L�/cX5˪Nm�\$���K�1\"O?��2�ZQ6&F�ҥ����<�򵯨-�6�+;�ʱǴ2�J����lFMCL�*1{D��∢�����7ъb�Rl�	?�^6,�	����~M�%&��&�iЪl^jL��\"M�L1̆jdZ\$@#nㅔQcrъRp�,��/0���lzW��WP(@�vȍDt��I&%+�5.�\$�i\$�2e2�0�T�\"Ю@Q�#�";
			break;
		case"fr":
			$g = "�E�1i��u9�fS���i7\n��\0�%���(�m8�g3I��e��I�cI��i��D��i6L��İ�22@�sY�2:JeS�\ntL�M&Ӄ��� �Ps��Le�C��f4����(�i���Ɠ<B�\n �LgSt�g�M�CL�7�j��?�7Y3���:N��xI�Na;OB��'��,f��&Bu��L�K������^�\rf�Έ����9�g!uz�c7�����'���z\\ή�����k��n��M<����3�0����3��P�퍏�*��X�7������P�0��rP2\r�T����B���p�;��#D2��NՎ�\$���;	�C(��2#K�������+���\0P�4&\\£���8)Qj��C�'\r�h�ʣ���D�2�B�4ˀP����윲ɬI�%*,��%����*hL�=���I����c˞a�\r�)��KqEÜ�K�J���s �*IK�72h�N�������k��V.�X�(l+�2# ڈ&�47Ã�<�*/���8@�����R�ЃٵG��\0x�����CCx8a�^���\\0�V#���x�7�jGC ^*��ڗ%�̗(o��|�/ʘ�60�T5V*�LQ�z�0C�q21Lc��a\0�\0�5~0���8,�H�2cc&��P�0�Cu����\$�1�C���zj:!��eO2I҄�,�{*�l�S�Zql�X�0����\n�22o�[I�.�Y0�������\0003�C=r�\n[�B�1�2Y��y�\\�B��[�S���4���ci2	������}B���)�c3O���P6f��2�&U/�b���g<��}�O���i�z1T��1��(� �C�m��26Ę0�篱�=`��T��A�q�5�UB�&���@�U#�c\"���!�yc\nO���}O=�%Є���CO����gΉ�!�ݔ���y|0��\"3��Ѳ�r%�8*X>aJ*;g�]m�W��H�&���Sk�Z�E=4���ih.H7�U?	�*�ж��Fa��7�����J]r<��qE����Z�)� �y�*)'T+\"�U\r�n ���g��E0&h2�d��I\$���XI� X0��.>I\nI]\\i�s.��b�^�zH������=��0})��bH�)E����pM\n�p�h�j�4M��}�t��9G�����P��J�HRɱY&�C*�]+�v���ך�o �|/�����`l����/MT��*b'E����a&��ْ��l�:�u�����\r��51Ԅ��^db�bZn�-�����r���O\"WL�cY��3�b��[*ԟP�4n�Q�)*���3���ڇ3%����le�iI)��p����YN1�\0PU��+�09��b� n�%ؚ��P+�iN0��8���AA��*�x����d؃��CI	df���zJ�CppE�y�4��Mɴ�/���Wr��L�Aih��B�K�m�� ��JL��2q�7O�V��;@&�I��\\i\"��5&�'��d�Q�K�U��R�^��^˄���\n�!��K����OQB�O\naP�B@@�u::��T�Tj�1?��H��v:��5��W`�ƗH�b�<|�|� \0���-?\n��{VSV^�p̸DR��0w�1�\0�*	�(�/��(e���>�䥐�C��%:^���Ia!���*��xNT(@�.(�A\"�����Y|���5hA�l��m��6�zN��R�<80�:NA��X7�� ��˴?���P��!�-\n�9�?��&W����J\"��\$R�B`��B�õ\nå�C���=Z�]Sy��	R�G���K�%1�g:�R%�ʔl�\0�����4\r�6��d�S�:OD\$���c8)� �Z��+e_l#��j������IEl脕~�\"\"��*j\"C��F(�67ASXs���:�����|O�9�|�h���&P4�c\$�t�٥�������A�{)3�B�1%f����e��T��x3�ɘ�\"�q�'�/~|\$ỉ��pfR�rW������MKqbц\"C��0�.�m �_��S*o��@�BH�ɔ��J�BYd���P�eM��5���B�*E�P/`������R�1��T����-U+LԆ:�F��s\\-C�?�ʃMn.�����S�۷�>���^!=�[��(`�i�\r��O�>�`�:jU�vp��wY(5��aQK�|���T_G۽/q���ǹՇ���u~����@�a+���S��~L*Y��!����9��Nh��`d�h͋��m�+�P�t�����\0�^��~A�u��������#����F3���\n	\n(����?c����V'`Ng�~���N���\n\"�\0�,�'�)�1o0�㴞-\0� ��'gjO0,-�+��?j��C�/�j�Pf�#'��'g�l���mbN�\nr��h ��¨\"��h���\"`5��\n.L�̀�f�\nhEĬ#����2�8�ĞB�V߄lkl|�P��F7\r��`Ҍ���PC���x�)�Ҭ���v�&�������vl0{�ϰSpk*�\"{��Ќ�wg�|�q +7g����a1D\$<�N?�����0�����%d�Q��SP.HOZc���OBh��`ċ`ç\\�P��y��N�T�iPl��x�Q���P�SBǦ��B8����˸�+�C�O:���ȡT�\0�\r%�(L6�@.�s.r\"�3�!F��*��C�c-Ϧ����J� R��BH�3��.���.��e�2�,��Q�&_1�'���]K��1�pn�\"�Q'�2nbgQ��p�O�*�d�r�qe�S*���lQV��0�r�,�)�q-��*��	����W��HĐ�ƨ2%*&Һ20\$	��pa�(����3Qu(c(R�2D�r�\$�-��an8a���f�c�d�o'Bfo�E.ST=��4�k'�2�bR���x�)3#7C�7��)��2sv����&�D#��8n5�8N\$t\r\r3�B�rJ�-QE3ӲkS�-��;0r�6㳷��g,�.8LN�9s->N4�S�+��<S�4�s>s�?�'4?s����e�N_-�N�\$�@�4 S�i��FNwC�,S�\0�*J�A<1\"'@�?qJ�s2L���Ƃp��.�6\r8�Pvh�6wk6�4p�(&�4v��|*\\H�|1栊�b!ͪ4�����?�SJ�zPL�qeI �,@�lH\r-x5r-*\\m��6��si\n��1!�R*2��81c8O�V\n���p�Or����N��L�OQ�,���\$BHO%>��oK3FU�[4G\nv��NC�@d�}+�vn>\0ET�D5���d8�e*4��\$���\r�'�/ƈ~lO\n'�r�h�b��:3�(Oö���4�RV,C�w/N�bc4�g,̒� d|!5�Q����I,�[��[�#Cu�]���5�U[h�;e�&���o�*2~#�\nq\r�d.������:��B?�m�\$%Ua��bBc\rm���\0�D��'o�����s�,0�\r�1�=5jMK2�㢈��茰�l�+��M�v��)b���0\0u�1�ޠ`�rb�ӒU@�%��B-�l�؃��D\r�";
			break;
		case"gl":
			$g = "E9�j��g:����P�\\33AAD�y�@�T���l2�\r&����a9\r�1��h2�aB�Q<A'6�XkY�x��̒l�c\n�NF�I��d��1\0��B�M��	���h,�@\nFC1��l7AF#��\n7��4u�&e7B\rƃ�b7�f�S%6P\n\$��ף���]E�FS���'�M\"�c�r5z;d�jQ�0�·[���(��p�% �\n#���	ˇ)�A`�Y��'7T8N6�Bi�R��hGcK��z&�Q\n�rǓ;��T�*��u�Z�\n9M�=Ӓ�4��肎��K��9���Ț\n�X0�А�䎬\n�k�ҲCI�Y�J�欥�r��*�4����0�m��4�pꆖ��{Z���\\.�\r/ ��\r�R8?i:�\r�~!;	D�\nC*�(�\$����V��\$`0��\n��%,АD�d�D�+�OSt9�B�`ҧ3�Ԫ��\"<�+0�R����I\n�᎒]7��()I�01�A\0Ɗ�-� ��e0���@����[�Co��H���(���]��0X�(�͌��D4���9�Ax^;�tiU)Ar�3��\0_ؐp^*��ڼ��p̼�*r*�|�\nc*@1�r*�V?�X�u��j9��߉�{��\rKta�z\\�7��&7«\nA\$�Ԩ+��>� @1-(��yk8QC`�6��Tn���\0��O#\"1�y+\\X2��T`P���I*�2��+�|�w�*ǈ����@P�3�c<i%�P��Ǣ��\r��4�ʨc�@���,�1������\r�T�&�O~DQ �mt�WQ��������� �(��T��[3���N ��U�'�ϝ/N܎#��@�l۬9�=�~�w)Χ��T�X\n\rCU�bJIY1�(����ˌ0���IxT��\"\\_q�P(6�7��*���GL(�L��C9č�gt���뽟���֋��l�0�\"BW��*��U4��i\$����tH_��D�\n\n�H A+�L���t�\\\naL)h(�lG��P�k؄p���XT�Z�)fy+� �z\$&�����p1�C�b B��T-���Y(d�d������Z�Ylu��N��[�7�_W�u@�;��ֽ�2F�&\$�����BA�\n!%h���������:_Ca�;�ɖ�\$ u���e�HдV��Z�em���t0	�=.���?2\0�@O�J�p����&�	I)g���@��bk��ƀ�A�1�p�B`�\r��W��L�I��K*!�Ҝ��C�f3�� �s�8àh&�|���Df�!�A�<>�@����\"g��B���D��@�(��AC{�C��`RnM�SFl���@����)������\0gKR(�?�\\՘lH!�-#*\0`�aFq!�R��,�=\\���2*	�o���bb	TR}���VA��4\"�~C:�ed�|����XxT5�䐒��?(.����:�MGȞ�H�Jk{FMI�|ó�\r��FC�X�����x��vWC�/E��W�r�MhP	�L*52r�#d<M�%�@m�R:��ķ�cL���F(.�����\$D�A�c:�jE%��6��4�����W(F\n�\\뼲L�,�T%fMB�ha���AȾ����<mg��Ud:\n:��T�\"lBT\n�&��B�	�8P�T� �`�R�K\n@�.��R9L���,�A@�4�B�ˀ)��-���r[6l�\0��*��%�d��b�{<�*��O��5�l�S��� d(쫄:��{K�})����X�JQK;gP�sRKOI8�R�ޭR[O/I���LӊT�\"�X'vz!���TE��Eh�Vg����ףt�Y�m��~/ѯ����`ـ�v\n�U3��N��4.��\"V���VT\$iTʻ��aj|1�m9?�U�v���8{1��7,o��:\$����.JS�V�Ľ�� @N�����Řhsm�7�2�3^�t.�Ȇ49�V�eOSfV�N�̎ͮ��������S�E�,�%ڄ�����*L�/F��I\$gU�&��,9��qL�7���^ʹ�\reD�W�tS���w3�8�)���\n�f��5U4p�p	R�Ǣ��h:L��Bu���ȱ�\r:z٣�^���(&��0�4]յ�X��/X���:2�}ãѵG��vq}�'��5�b|��0����Я1'����.�!�]`���r���2�x�{�)���x>��})wƇ�6�f����T��4FXyjK		�����K��qg=�0짘J�J�ٵ�EM�NL\"�<P�&����vo����\"[�7����#w�)�^�ߨĚ&}C���]jTʴ�Պ^K@ʝ���d�!@�D��k.kbR\$��%.l��O��\\�O�]��#>)L�N�B5��1�j��p��Jۆzf�p0�PH �p,x�Vg���o�9#\nz�~΄�K\"�I/А�|ul�f�7�z����t�]	���,�O\r�UP��G�wO�g`��b�F�0�����*c]o� `@a\nV�.�5N����P���D��Nwʰ�α��m�\$+�/��\nP��D�C����Q!-�ɞ�\\��~/-�I��h��,2h���8]bo%�(i�E��%+�j�_����I�|{P�j��\rʂ�f�<O�dFQ%c~c#��-t\r��y���\0��\n\"�\n�\$\$��Q�ٰ��q���0%1�0����e+��Q芇������k1.7\$� G��OH~�f�`�q侗7<����0�����o�lP>!R2!R6����#N��\$���pk���M�75%2\r�Xk�&�f(o�gPRw���B�>����b׊��RJ�2�vR^��c\n��)r�*�� g�)R��1\$#r�����Ұ�q^g�m,�/pF�M�����.-���,�����/rW�pL��/��&�	/K�\n�fg�\n��\n�h2�2C:����S/2�	&\0�����r62��B��ff�X\r��(b�4.}5cZ�B�6FPd1�`�E*\$��-7��h����Ϩ��q��FD�\r�Vhdj0C6�҂j.�KCH\$P򢐠�r�pTrXp�� ��Zt�bD�.�����D��.#\$r��B|M��\rQ�%�L_Cb;�;�\n=�҆N���0��-'n4�A;c��@�tJ�*�@l��x�L�t3�K8���\"'\$<��(�B̪!@��a�\"̐xC�x�\0�DACH�HMi�uG4��\$��)�H�D�ԠTxI��O��ԦS}Il���slvRl�O��M�QpoB\0A �/��\r�JM2E �#JM�6�*)06ǣ\"\".���+F�d1�|�BTX)����g��m����;��+ʃ��:#~\"�\nyh)��B�\r�";
			break;
		case"he":
			$g = "�J5�\rt��U@ ��a��k���(�ff�P��������<=�R��\rt�]S�F�Rd�~�k�T-t�^q ��`�z�\0�2nI&�A�-yZV\r%��S��`(`1ƃQ��p9��'����K�&cu4���Q��� ��K*�u\r��u�I�Ќ4� MH㖩|���Bjs���=5��.��-���uF�}��D 3�~G=��`1:�F�9�k�)\\���N5�������%�(�n5���sp��r9�B�Q�t0��'3(��o2����d�p8x��Y����\"O��{J�!\ryR���i&���J ��\nҔ�'*����*���-� ӯH�v�&j�\n�A\n7t��.|��Ģ6�'�\\h�-,J�k�(;���)��4�oH���a��\r�t��Jr��<�(�9�#|�2�[W!��!��T؂B�-i�q5����Ld��.j��tCA�f�Lק��� ��h�7;�s��>�����1�3\0�3ӯs���oh�4��@�:��@�o�\0�d4C(��C@�:�t�㽔4�&�����}i[C ^)a���=����\r�<�7�x�@Hc��ω3��h<�!�\\��H2E����Iâ�F��\r%�P�0�Cu&3�A(�!1�<զ��O\"03T���i���\$�t��Q��p�Pk\\�a��w�n� ���Z{�Pz�Ok�T��i9-��q�kx 9ӂ��k��F���!�۠�\"	��Ʃ,���z�}���@��B��&lPI.�7�u�<���W>�j���il��\rb\rĵ�����U�k_\r�-h�!�H������6��}6��.���<�	�<�k	ɺ7sXC���Ǻꁦ\$Ȇ��%?N�!7������w��l�[y�p:V���5p��ޖ	�v8�����@h�9��̫^�������P��z \$L\n�PH��%H	��O	����u	q�5I)@��	�i�-]x���X�d,��tZ!�i�SޕC��[`��<�L'WJ�@D\$��sNNAj�t�=�`^���C�kߑ� ��/�L�,���`�5���J˂�<�%���\\KɁ1-���	)�O��QÐ|A�2pj&!��P��:nj1�\$B��!�le�����KP9'd���@�{T�1L@�U����}q� �X�a�v�0��f�|6�Τ��\r\0�V�ԛ)�\0cW��/C��.���GC\\D!�s�\0�\0()`��HF���p�Q��ެÐi��'�yP����I��7�<v�Bs���(�� q3s��K��|��s?��K�{CCppV\n�����'@ir�Iu�(ma�:���\"#�\$�5CML�R-H� ��X%(d���hz��~��S�T�R�q��bzK[*�'t	�\"�5�D�D���\"�I4�y������O\naR���JC�A~U����d���2U����9X!#�,��2c�%W~D��3��I�hF\n�`�1,�N~H�&�s��П�tӣW\r�͎O0�?\"=W�f�����k��&�\n��2�N\"�[e���G��fl�2N���{.LI�����\$�F��],v/�?X�_U\$5�Od��'5^I�f��ݻ����y���9���)=r�\$�����	p�Ї2�E��-Od���Z��Қ�ZlXC�������`��V��C=-i�Y��U19��&@�1�~���'zI��un��<�V��\n�Do���J�C�FL\r�w��0.,Ϸ�@P��5���C�w��#�O�&j\$�jL�YX9U��V�H�yk� �X�]S1v�z^���\r�+�\r ĕ9H�T\n�!��P�^Ԏ%��\"�9#�de�\"�\\�\r7��@ &WL��.DZ9 �@�Ip��]�#�@�ȱ*F�+'���c��i�4��E��a��A��\"d@`:!��R��]� %�(����BL+����א��\rQmt{u\r�-�H��څ]\rmX�|�e�1:W+��-����L�	7���25O�覫4@ZQ�s���2ps^Q�d6<[�CĒK\n��c/��	�\n09�?y!��uB�ڛ�0m#�%�2YR:ˋQ-ELš�..��D<!��<.�(I���gQPO	��/B��Kӻכ[�tQ��ae�p��7�M�v��8^ZL\r�/�X�g����s2]�rs�vo�����&x9�i�&����sv��|{�@�7M!��귓)-m��y��ؾ��<�Z��N2��2V��ޣ~5�����r�������\"v�bk�j�6E����E�q6�I��?����͑o�>ђ�ֵ���X��.޴��¯{s5�1��C��0(�r�+�'�U��̫ܲt���_�L�\r����\0�@�Xհ�p�:-�A'��BL���ξfP7\0��B ���9l����Xn(C��^�Hn#n\"@m��I����^���j0M��P��:�0~0o-f�o��T��s���/1���,G��\n��\nâc�\$� B 9�J0\$�7�P���h�.�(��ds.h��0(�0�#t 0�o/\nG\0��^��Ϊ�:j�I,�K�����\$��R��2��+z�6��1�^��AQD�6�-�Aq69nP:1l��0n2~�����&\n�܏�v��5�Z:l�	\$k� #�U��l��pD\"R�`��VQ,Vh+\\0E6�6��6ʴ�#\$݄88k����&�@V\0��qH��G�t�P@q�fq&��.}pf��\$)��cH	qW-q�2D��.%�x}�@`c:�1z������,�`FL#Ǐ\0'0��\$ǎiI�\$�x�F\n4���.�0���'��jRC2�'R��r�/-�#�b��:�y�O\n2s)��/P y��h� ��ĮM��k�L^��\\�t��܋2g�p��+�� �p��E�od�.2!(�#lEȉ�V�/�\$�]�Pm�0�\r��;��\$�jM�#bǎ\$*���vRea ";
			break;
		case"hu":
			$g = "B4�����e7���P�\\33\r�5	��d8NF0Q8�m�C|��e6kiL � 0��CT�\\\n Č'�LMBl4�fj�MRr2�X)\no9��D����:OF�\\�@\nFC1��l7AL5� �\n�L��Lt�n1�eJ��7)��F�)�\n!aOL5���x��L�sT��V�\r�*DAq2Q�Ǚ�d�u'c-L� 8�'cI�'���Χ!��!4Pd&�nM�J�6�A����p�<W>do6N����\n���\"a�}�c1�=]��\n*J�Un\\t�(;�1�(6B��5��x�73��7�I���8��Z�7*�9�c����;��\"n����̘�R���XҬ�L�玊zd�\r�謫j���mc�#%\rTJ��e�^��������D�<cH�α�(�-�C�\$�M�#��*��;�\"��6�`A3�t�֩���9�²7cH�@&�b��\r��1\"�ܠ�Mc\"\r�0��I�%%4�D��aCG1	B�8: P�6�� �=�))�-\n����\rJP�1�l-7�sP�@;��COa6�@9�`@&#B�3��:����x�u��\rl�A�`��|:9��^)���5���\r��7�x�&��`�#bK����5�Lk�'*����i ��/n���/��A�d��a�CRB��0\0����r���2h:9�|�hD5�P��bC�O&��&ʌ����#����䞩�53�\"�0�:�!\0툎�(%�o���;�P�:�c�\$�i��3�<Ɗ��F��C��\0\npe�X�����)X��\r���*�� �R�0��X�������˶�ף�7G∙j�]��2C;G��MAEѮV�e���)��*%\$��]���v�ZL_���Tu{�B�d�>�8�:���6��:����ۓ���u�{��]��[� Bz�����\\��3n���cP��ho����n���>�P7��\nh�xCcfЎ�{�Pi���`�	wɡ��փ((`���1�J��f� 0��10J\r�=!f�\0K-��23���bP t��0��j�����j�BN�<�k\r���j\r@�4��\rJ�\\+�r�uҺú�]�h/%��y\$N�uA��}\"�2�a,,㷀�L�\n)F�5%�趌��9ʹXs�.�S�8��-U���}��\"%��c��\\��t.�ػ������>��#W�sϬ8i2\$�>NFH�srN�\$3C�j��ld��!\$2�I�!��`謄r�U��Z5���#�D�N1�3d�1���i�6i��#\$�Cf���b��M=�L2Zh�Ӽd�\0c��\$4��M�qw/1���d��!2}������/k�5��H\n�Rs�\n\nb+d|��5B��m f��Sn�_i8J� �\\��?��!d�H>\n�l�C2\nLC�X����rZȅg���i뎁V�2���'d���b�gT�R\r�)�,��%�ޙ�a�:E��\$��i��Z5�]Ȝ�R�me(3 �Aպ{�� 1�*�i�*��4�#�,�PP	�L*b+#�\\�:�+�(�%�-��KO����)<�s�U����:���vėr�U�7lL�sj���#Jv���=}�h�Z�zF���.s����̘y �瀫ZPY�9nl��l|ΎiM07��Mc�a�a�+��BC�M(87����tU�uѪ�(����\$����ؕQ)\"���<���\\;Uz�?�FPJz�{�\nɆ����N{��G��r��z��㓰d��\r��+�bś}b���CH*�+i&�ŵNB�}-�&��ݓ���໩�C�o�L����!�?2���dH�]Z�9.Q=�_��#Tt�&zm(w#�t��FR�Hn.a�r�t�^{!����d�� C���l6�pD��������T6M��\r�;�����a턃fo���m��q����@\n\nMh��UP�yxm�\"�50U��5{X�/�@�BH�U��!h��Cu`����)W[h�whЁy_hDX94{�92�A����w\$x�	�-����ZCk[\\�:q��VW .8�5�^r��a�h#���p9�K������z-�nO��#�\n�65\\�0󾦞�����g��ӚA�%\\�� M�J7ۢ��8rɾm=����z�Պ-�\"Q���m�C�� u��k��רj���r3��2�#��U�QG%1�yV�v�'q�|� �{w�PC;�n�b)p'��'���S�ϦG���% a W�'̬�g��Xl5���3[��'��S�u<cr��/l��i��N[�x�`�~�\"���e��۠�g�?�R?%� c\"��K\r�\$c�C�0����!��a�oEpb\n+C@.X �����PE�>�,��z%`.�v��z�~��G�r�ffjLih���P(�R�p'��G������]ǈ��s�N�I�̛\n'��o������2-����y�O	���Ǫ~�)����fЋ㐯c0?-�k�l2`������� (dw������<�������U#eh��n����	�Q��q>�&El�Lڂ�WîAC��\ni�Nl8CD/x�d\n/C0I�FQ|GL�`�[BcRG\"F��j�\"Z�lj��[C�����G��e�QD�JR��5�u�W��wm��f~��ͰjO`�q�î�g�'0\0c�P �T�r)0����2���9!��l���`���!-Q0�r��\"��#����\$l�#�;�N#�H�2*d��+@�O���T�N2�&\$2c:B��f-R4Fҏ�� �s)d\$��n��on�rV�):-�M��Lr��Q\"��z`�\r��+��b��,��\n� L��VC�%�*�&A��<�\r#/R�-p�0�0�O�q�02��&M1R��ra-�L>0y)&��-���3-3S�3>k��c��\r�W�!F*�M�#�\$3ROr�a�g%S;�5�q4����%���lvR��I30*\r�H�6�9E*����3j?C�3rkETY	���rrm.#WghF;,ғ`ʻ��/�S<��k��=�2�����>b~�:��\0@�V%o���g�Y>��hO�����ALJG4�nSAt%���&*\r�V��F�YF�\r�ښ�����\\E�n��V�Hd\n���Z�tPY���Cc�>�\0�g�HHT}H��H-P#�@\$BH\$�'��;frYO�J��\"�R�@�T�C���0�HR���z��<c���;�0D.�R����({%\n\r��_��QC�	��Gc�;z@�;FSA��c��j�&>kC������v0�\"����~�~<�<3i�3��T\"�Td�'�,�U@�5G5u@N�\n5I� �æ���\\��D+�<r+&�&b��2�E�v���nV	�4ְr�����Mu;F�&ņ��	��W�\" #��\"?<ΔR�<\0�5fH߀�S��Sƒ�j�T��U¹0�Y��5�;�\"��p��R@�6B�G��\"���\r����HfKa\"���l�W�t\r��";
			break;
		case"id":
			$g = "A7\"Ʉ�i7�BQp�� 9�����A8N�i��g:���@��e9�'1p(�e9�NRiD��0���I�*70#d�@%9����L�@t�A�P)l�`1ƃQ��p9��3||+6bU�t0�͒Ҝ��f)�Nf������S+Դ�o:�\r��@n7�#I��l2������:c����>㘺M��p*���4Sq�����7hA�]��l�7���c'������'�D�\$��H�4�U7�z��o9KH����d7����x���Ng3��Ȗ�C��\$s��**J���H�5�mܽ��b\\��Ϫ��ˠ��,�R<Ҏ����\0Ε\"I�O�A\0�A�r�BS���8�7����\"/M;�@@�HЬ���(�	/k,,��ˀ���#(��%l�(D�C���N���.\0P����\\�8\"�(�6�(� ��j�\"�n����c`��H@��lp�4�lB6��O���4C(��C@�:�t��\\(s�ܔ�@���}2��C ^)���1�@��O\n���|���Ғ��P�i�H�?8��ت����V˻����.@P�7HI2d:�B�d77��J2\$ԣ�%��d��h����@P���8\"V4�x� #K�\"TC�6#c�:��U���\0P������3�)L!�&<@̒B�M��܎��Z�����Qr��(���B�](�3�T8c�B�\$���&C��m�[s\$��j숀�/9��l�{\\��nL�ڢ�(�3�սT ��{u������69� ��m�P�id8Ķñ)�7��2�Y��^���b�����@���M3b���3��9�C\nF���!\r��aJ[�mj�)�B2��\"	 \\	cK(6�m��X�/�)iC���X��x�[��]�ϕ�QNr�)@S�UCQԵ=R��j�V)���ep�y�@�* }��Y�8�b�zS�������i%��.�5v�Xxrj����>��\"�U\n�V*���V��[����IeW�\$��0� �>I�4�����kw��3<Rqd��H�C�I�4\r!������b22�<��\"P�H��)e@:�~݃O_�Р�3FS�A�&\$t8Y�J	B�D�`s�K�M�\0�	�:e��-�PRL�*Ht2ʬ�A�3�I��s2WÄ��ҨD����%���`	�h����� FTS�(&�b��~IZ�W���2J��:�&�\0�6,�K�uCm@2���Cj\nԧ'� j�D�{l����r��\n@��5�*KBI& ����H�4��8��\"�;�~0nƿ��\n&�d����O\naQ��\"��ɡ1=/Q�����p1)ؓҢv�CYP!�7`�H)�M�g��C(K����%p 2�#I0NW��P�R�\$ �U�\n	d�1��Y�Ed�<'\0� A\n�V�@(L���i_�����ICh�����+�����g�g,��C��鄿*S��\n>r�'f.�-(��9�%ͼ��cJ�R�Z����\0��a�N5����J*�I���#���)	���e\"`��:B�����Z�+U��.\$���;)�[�Lb4K�tΫ����=\$�hL�	'�©���j�6��t�{����iM�N��s�R�\\���YJ�j��1� l�%Ë����\"�y5�I�2%�F�PR6�!u�Zz�k�����'��C	\0���c6�xo>�9��>'#e��8eZ���,��(����,6)�~`��%D���\"�(�nD\raծ��N�	�(�ߜ��M��i�<����q9�;�]?��ȉ�E�3�L�	��؝���=ؙ����1!r�MԎ�P�1]�u��>�:2\"�>�2��9��O�FQC�1\r(̂��^�A~.��U)���R�2�AZ��\"��b|Y���E���BI����_4=�.[Sn2�Xu^=�ݛ��U��w^�L���[a}�DuFW�ɘ�\n3;��*B��M/L��Y���J�&�H�q���; -y�ӽ��\"^��`��W�A�h\$|�v暭���{�lZ�]i��%�t���_����Ǡﮇ�b�?���nQ���u�[[�u�����.�k����s��xȻ�9�ˍb'2��|f�K~3]�����z���=���w�U�w�����~���b_�x��\0@�F(1|�ļ��8 \rL�O'���/{����M��~->��cL����r0�O�+9��M9���I0�F�I�3i�{>���@����j�(> 4��m5��5�x�\"�/��?��x���(e���l�\$�X���d��0�*�j��;\rA�i��-N�w����[o�����P ��\"m'`#�Lm#&��8p��&JM/��#�\0�h�#�0b��bP������+kN���'Ϡ�Fҹ�B����#K�i�n���m/F�o�#p�bD��pf�Ъ\r,;��0�	�.�/>ð���F^\$h^�5��ǆc	�L����\r�Op�LX� �Lb�fvj�Z9,��7�h��h��w�.	5�~����͢Zd>\r�V��\"�ʩf4|�Du��gTR�Zʢ����x\n���Z���R#���		pp'�\0=,�wD`�+^q� �,bi�C�ق�;d��&�P��\$j���,7\"@�E�(�!\r�	�ީE����B�:�(�`K� �HKo�|����Z�h�\"�,���\0�'&h� ����bs������r����O\0��-����IJ�J`ʇ�@���رbt��g�jhNZ�X^l�~��|���#\$/�\0�C�\0I�&00i�-E� �V;ţ!I��Klo\n?��iBH�K�5��L@�2�Cp��\0�Fgg��Fjr1+�BDj2\0";
			break;
		case"it":
			$g = "S4�Χ#x�%���(�a9@L&�)��o����l2�\r��p�\"u9��1qp(�a��b�㙦I!6�NsY�f7��Xj�\0��B��c���H 2�NgC,�Z0��cA��n8���S|\\o���&��N�&(܂ZM7�\r1��I�b2�M��s:�\$Ɠ9�ZY7�D�	�C#\"'j	�� ���!���4Nz��S����fʠ 1�����c0���x-T�E%�� �����\n\"�&V��3��Nw⩸�#;�pPC�����Τ&C~~Ft�h����ts;������#Cb�����l7\r*(椩j\n��4�Q�P%����\r(*\r#��#�Cv���`N:����:����M�пN�\\)�P�2��.��SZ���Ш-��\"��(�<@��I��TT�*c*rװL����0Р��#����1B*ݯ��\r	�zԒ�r7M�Ђ2\r�[���[������#�ù�4�A\0��̏�X���9�0z\r��8a�^���\\0�ʴ�z*����2��\r�C�7�Brݤ��^0��h��7���=Rm�i�h�k�\n�����/K�`�*w:�Mb�/�r�;#ܵ7��P��ApΆ�� @1*����J��\r�bH�Cp��!ǩ��6�+X�RcW�R�#���6C`�\r\nw��/�3��`�3Ԍni\rl���cp㕁B|��K�R��H����Bc3�7A_�vfP䦥#݈Oo`@)�\"`0�L+����M�ҮSS�]���p̶!ԗ�-6|{�=;��ͳ�(�6�K��9�+�\0002���q�4\"M�8ih�d�� �\"	�3Δ����\$67����s3d�%;�t��݌,j�yxe7M�@�����5��\0�)�B2���#K����&b`��L�;,\$cR�����7\n{G�c�e�Y!��V��0J|ܠb5	�T��T*�X����V�)[�%r��alY��`��Bi�r�ZUHv��@aS�� �MI�\"^�������?E@<!�H~���j�T��Z�ՈwVj�>A�?	zQ@�a���H�*�(#�2��	9{0���ě�hL\$'��t>W��0���2>J�1UCheI8F���.�d�@2(��f������G�R��4��D��4ݖԨ�b�\$A\$�<*C�E�(N0��� \"B��RA\0�(������)*�A%�`7'��Mm3���0g\"j�QNQ�7�yG2�9NKy��F��|y��p�e�	,�X��)�}ù�o���*�Hg��d�\r�E�K�\r/�((0�eV2�E��֠��B�ɑ&,C���jMZ�hh��@�\"���D�1�#�j&��3�7�tH��D�	�L*>@����y����Jƨ��&*�U�l^���1����`��%4lIZ)&c;i(6��`�/�&NF6RTzC邙f���~�\0Q�^�l'��@B�D!P\"�Z�(L����B�X����p9J��Z�j�a��haB7\r-M���Ϛ�>&�ԣ�@U?\r��£e�|燖�����D,t�l�r�i��:\$Tܙ��	��\"�?#^\\�0V0R�\"*��Ne����_�d؛��}4&��͋Qhb�b��46\\˫,[���D���4�:��7G9m�w�\$Eo�G9�pw[r�K��n/D��.��<0م\nj�>�Y���r�o+��Z6�`e1����6ZL�_�6��p`��ޑ��=�Z~b9�_�ed�b���2��4-�.�\nl\n�P �0�)3�V��#�7΀r<�]��V������b�X^v��iچRUP\rJ�.�'��>�3�������s�s��7�MQs�TX�,��[,�ى!����J��(g��R���F��FJ]��sq�weGT�Ou�����Y%U| w!�=�J,F\nc<�t%~V3֐�Iһ��\0䗗�eGo��y�&���^�����6\\K��\0�t�y��D]�/РɎ)��k�r���r�\r�:p�a�\r��o�r�Ӈl�p�!,��Υ��x�mX���?-�	�����/'6�.�CAX���f��-d���dA��[�!���n����ۡ5�hđq��1�#v�X�  7�L�`\nU�����>�)�j�)R\"H�^�n�W�v��N:�ꇘ�	��}7�w�	�9&J�wQ-�,��\r�tYp�L����.Z;�\"��|a���fB�8vʡ-Ɋ��k»[��x�3�@���z�������#���@9�F�m��S:�<E�N�V�#	e���(c��A����\"׆�&�U��ß�n�eU�(~eKt���qc{�o�W�F��5|�&�\"��l\\-O��%�J�`�%��p�N�:�[�b���s ]��ڰ�\0��h��/-��g0�Noh�_���R��2�l�� ���@#�~�K�׍�u����!n@�������(ï#�f��N&4\r���b`x�̮�Ф�p�G��C@\$�K�F�.���e��[H��ep��u����rː8p�b��'�B%mLD�NL/axC��Dv4#J@Q\nO���@���DEq �Ucw��	�4\n�~����QL1�s�1Ohy�.f��Nh�*\".��\n�\r(y%N�q�x	tC\$��𡬈�b��~a����0��Ѱ��!b�����a��\"��-�\0��LC��#�dͶ�\$ X�*_FB�1l����.*�`�\$c�\r�V��\rm��FR�\$򀑌/��bOTA�f*i� `�\n���pIr/F��2&\n�>�����!%�RK����s,.�IX1bP%G\$�llG��2.;��y�0-r!(��l\$*F*b1\"mZ%�ޫ���G+h9Όy&��d/��0B1l�,ςsIl!��!���b�,�<%�'h�.%�4�/�-��.10�C��0N9/s.q�I��@5c(�B�{*j7e�����:g�`O��-��/d%Ʀ�e��V�p���ʤ:B�F���BE����6���-�������0��6r�rKP\r�TykMn�n�11�0@�\"+�����ŀ�j�g%��1@�	\0t	��@�\n`";
			break;
		case"ja":
			$g = "�W'�\nc���/�ɘ2-޼O���ᙘ@�S��N4UƂP�ԑ�\\}%QGq�B\r[^G0e<	�&��0S�8�r�&����#A�PKY}t ��Q�\$��I�+ܪ�Õ8��B0��<���h5\r��S�R�9P�:�aKI �T\n\n>��Ygn4\n�T:Shi�1zR��xL&���g`�ɼ� 4N�Q�� 8�'cI��g2��My��d0�5�CA�tt0����S�~���9�����s��=��O�\\�������t\\��m��t�T��BЪOsW��:QP\n�p���p@2�C��99�#��#�X2\r��Z7��\0��\\28B#����bB ��>�h1\\se	�^�1R�e�Lr?h1F��zP ��B*���*�;@��1.��%[��,;L������)K��2�Aɂ\0M��Rr��ZzJ�zK��12�#����eR���iYD#�|έN(�\\#�R8����U8NB#���HA��u8�*4��O�Ä7cH�VD�\n>\\��B�C���8�i�\\��A\\t�/�>�W���3��) F���gD��[�5��\\��yX*�zX��ME�9o\\qq# �4��@A\nB�t3\r����#��գp�7�1B-`�4��6\0�D1�2�\0y����3��:����x�\r�zAt3��(���E��\r�[Yz�X����px�!�c\\Y\$~���Y�@=�&��9\$��'16Z/���%v��l�I@B���]G���D\0P�0�Cu�3�A(�O��m1L��Y�h�C�Z�Fs���QMg)\0��\$	psO��KG4�Ȳvuls���ZNiv]��!GGVO ���s)1�y	.��l�1��I*[ȫ�J�P�:��cwQ�C�7B��&#�y=�&\\�-�=���H�_WDy_V��Rl;����<����O���1<x�)�j�Y��P*O�y\\\$pN�UlG�\0�QJ�\nAf��9JMջ�!����~j�B�\0�!tNy�����4�!�)���c0V+������o5�7�@U`u`L3=@@xg^�͌È�C8a^��1� @��pu8@�9���z�h���@���FV�-���!��'8�����JCH��n���JDGV�PԠ#t�U8u`�xƄ�C�U��{1�PǙ\"d���2�Xˤ�fl՛�EDK=�٤0f��Q0�d����P�ci'�~�%p �)�]r:	�v�-��H2(@�g�P��T�坱t�icȕ�1�P�Y%d쥕�vZ�׬�Lћ3UT͕j�g��\$���m�k6��)��\\���5�4>�\"e\n�3\rB�R92	1>'�Z.�\r\"�H�vFICX�e¯=�\0�k��%���8��R`l�*�h��38��4��hH s������F�#dp���3ƀ�bx@PE�m�Tn:�D��:�0�\"�D���2ē\$�]5�ф5^�C�`��כfmM�epk�:�����\r���F�qc�RD�j.��K��a!�08ȁ�#C\r��51FtŜw8��4Fp��68u6�4NbkM��G���XQ>(�\$�~�*�t˴I�lhA���|�%JI�(�!	t�*Q7&��A\$��vK�_Hi�Q�n��q���dA�f\n�ؠ`��L�����T}�e(j I��!�G%�ˆڊ�)e4A��,)JF�\$0A>���@����]LA6�>@�szw����Xe�\"�[�@��` �@F��Pa������&���9�^E �\"�B�!E;�wÔ];p��\0U\n �@��� �&\\�^S�Z�G�+�����y����1�=b(拄�|E!A�v�GKG\n��j+s?\rT�/A��d�\"#�aN��BIι�C6o}*�ilb�u�\$oP��醯�Y�46N9�P��9\n�T��q�<Mm�+@P��v����#V��*%Rё�+& ���ds��(6tv�p�BH��bNť�W&^5�5����#�]D\"2T�Il�c�T��UZ ��%�CHe�Q��6��`��%��#1+���Hͩ�6�p��s�W�ʼ�~z��kͭ{L@������?��\"b�zkYkI����B�]�|W��y��y�灕�t \\r�)\n�lW�ڊi�\"��l��C	\0� �Rn�ᬿk��Y��b���AyRL����̂7��k�\0�Mi6o!���o���!��\">��b\">�D�|�X��#bk7�잇�^��K�>��@2�(;���QJ�\"���f�U���iH\$���o���f�B��~Y\"�R?�#�eK����M��ϲ��J�����mA@�T+!�&��c\0���������bO!Zl����b6�����2\$2��n��#�>ON�g\"m���\$m�����P\"@�0v�#,3n��b0~����GPp���	���Ж�P�hBGn�����p��- ��Q��L�2shZA@�I ~Z%�/�G�����#�����I���wQ���]� sC�u�rI��m��\"1��\\qG�G�y�����Y�0��'�[ph�p�	�p�1J�q.Y�&��/���N[1Z����0�hU�gQ��`Z��\n�g�#�?k�<�3ђ뱋Q��a\"�����*������p���1n��V�Ѳlq��,�G����h�n���q��f��p�o�Gr��.�#��mG�\"��S܎�ZI� Ђ��4B���X�n�qq*�Oz0�~�Q�0d�+�RA#�	\$/~�J̾ME��n\n�N��%G��.Xk����\n��^WƿңR�)��Q+1�+n\\kҼ=�k\nr���ҽ1�?Q||���.�jA�C(�^��c� �o��g�:1�Z��\r2	.#�����21�2s���t����%��m�#���]3k�n�\n�ϻ4E|�3K,�����.Q�W�c2g�*�� �7Sx\$γ8�7q�7���r#�\r!s)83�7��#��W��W��M�5�9�;\"?;q��˗;�*W-1q<��MS�;��:S�Y��M��s�R����O���.�)�=©@�?@�����@�>�#Ap*�dOgF'���j��@#�>����}D�C�4	\"���1s\$]��3�0a0=aFh#��F�\$Ȍ�@������nx�.��/Ә�I�wE�uLr�E�gIax4�/O�~�}�hp\r�V���`�S�a �����\r��Ȝb�̨\r�4C*n���\n���pT)B�9�� ��a��uHC+R�	°~�\"����B���:d^�s69��\\2m�2h6UP2#&!on.�lEL)aT%�.|��>�uz �~=c�#�T�z'��1��Aj��9����{C�B/а#v��[��S\"N�\"8�+A����\n3�A\0�Tct5#V�FlS������KZ���2��gLG[�dƥ�0��%�Q6�mb\"���@3B�`\n���\r��:M��d�զ���B�%h5TS\n\"�.�Wa\$�LF���r��vZg=\\����y�]/0\r���d8S�8�y�7p�,k�2�����D�Ok�\0";
			break;
		case"ka":
			$g = "�A� 	n\0��%`	�j���ᙘ@s@��1��#�		�(�0��\0���T0��V�����4��]A�����C%�P�jX�P����\n9��=A�`�h�Js!O���­A�G�	�,�I#�� 	itA�g�\0P�b2��a��s@U\\)�]�'V@�h]�'�I��.%��ڳ��:Bă�� �UM@T��z�ƕ�duS�*w����y��yO��d�(��OƐNo�<�h�t�2>\\r��֥����;�7HP<�6�%�I��m�s�wi\\�:���\r�P���3ZH>���{�A��:���P\"9 jt�>���M�s��<�.ΚJ��l��*-;.���J��AJK�� ��Z��m�O1K��ӿ��2m�p����vK��^��(��.��䯴�O!F��L��ڪ��R���k��j�A���/9+�e��|�#�w/\n❓�K�+��!L��n=�,�J\0�ͭu4A����ݥN:<���L�a.�sZ��*��(+��9X?I<�[R��L�(�D%/�(��i����Ԭt�Ǎ��9���H�0�?��ݩ�jAc)Υ���W��ڱ�q:�ݫ#.�+t����Kp36b̓�q�A�l�\0��X@ ��h�7���w�C�R̨�p�.���B2�Zn�J(��J��\r��3��:����x�#��p�9�x�7��9�c��2��@*N���x�8*���Zv��+� �M��Η6����AA�[��C�3<�m���q�;�]c9���6��u)R���CR4�a\"C%���t��OX�S�Q@64�n��Kj�\nN�ԵO�*�9'^Ǝ=���w��v��5�)�K['ô�?�\$�3w��Ikr);�C�(�c?ާ�cy�J��ҕd���%EqH�CҨ;��)W��L(\n�'�ZZr��]/d��E���I''��,�η���>���ҞVHS\n!1���v�X#q@J��㜅Rr�l�X�A��2�t'|��H^�ɼ2�EHޔ�h�!aJ���fC�R���B~k���w.�\n!I[l�Δ��\"�Uc�!8���d	w��.(ʀ���\\K�桐���%����̱Iz�v\nU��Z�RA�A��A��s\\ٻ5��W��n�z㇅)W�5Fq�k�~�aw���UW���?�S���+�eGYH#cNu�lb7h�0��3v\$ӡ�DIYt��\rӑ�BYI�,Ό��C��9�%*&��fQ\$�NY���F@M:�>\$��87҃��a�\r�1i�)��/�\0��L�N����@�O\"Z�(치3&h͙�:g���4&%;Z3HiM02��C�i��U�8I-*�|5�)���N�`y��,������VQ4���@�ӒLf)( Ű�JS�)Q��G׵ \n�#���rK'Ե\$�� ��+'�U�t��6j���;g��;���Z;Iim(<F���Lj�Ύ��hd��e����U+:U�97�B�R��uό6���b�x��[�뛅�IH�M.�>�T�W,�r��R\"A1ߥ�#ӝ��V��;�@)�l�3��f��r�EH/Q�}0���	)������L�qU2R���Vo����:�W�)`�Ud[�9v#�u/�@\n\n�)4�m��؟Sݺ#�>>.�����ZH*o�w���ҎG	R|�bm��8ݛ{�%��i�k�0법�v��ӔYx���\\��Y��{��E(�@r<��}�X�9a����;��s\rv���J��\$�\r�Z�Q�c�~'v�T3Oi�A��h�r�w�������3��c��B��V/1�m9�������|!r5nb~xS\n�a�Lop9%��7l�S�5�#�%�ɩ�V���&*�|����̋@L= ��PȐ)�B-����:`9ǅV,�\nvl�-)U^��Pb�gh��ĔtL�[i��}D��C8�'.:{��<�?�[/+�D�F\\�*��g��}t����P1ӑ�Z-��ٴ������@ى7�n4Z��(.ٱH�{�,b��8@V���E��D���\$�`'J�l-�#ƦI�>/��\$-�q���}C(\rY�S�N,X� ��N���_���-N�J۽�t��H�U\\�-T���aK�{2��?��Us�xU@�h	ӗmVq��4;����l��˨,��F�w��o�\"�%��.+���~*h-�S,�w�g1�W�|4^r,{z�����~�7x��Crܫ�t)*߼A)\n/��t�i�ͭ=w�|�= �*W\$vۑ����)�n=a���;��@]D�9����v-�#��?��qλw�A��lL�*W��?2a�����ϑ��d�\0PA\n�P �0���l�R�UDar�an�U���o8p�m\"�o�u�ƥ� @��Ǝ��r�檭|���^<?�<p�:+�TB��\r��O@�H餼���'{�\n�����p&*�p^�鏠썹����vJ�>'�諰�Mf�+�l��*�>'b�����Z��w+\\)EJ�Ł	��U���,X�	��6※d�W��/:Y�w\n0��Ⱦ�����)F��&��\0��H/(8�B��|E�l�	��g�	�+	\r��I��ő�E�V����-\\��4�4=�bT����]#c ��rq�NΑT�\$9z�N��N�N���#�._���br#�Km���8�j|�%�)��E�x*�)/�\\o�y-�	%��+�\"��2.��}�Y���\r�#�4y�o1�Nέ��o�챌(�4o�2�H���4)\n���z����b���Sј[Ȃ��@p�d�Q,艾َ\n\$�:�D����\$�0��P���#�f�E��,�r_&�	&L����I&r�%�0�b\\�)\n����\"��o/�`�Pu<���.7q���1=\n�D�������&���ro)2�著-DUb��e,�i-O.�{'.KG�)쓦�B���轣{���\$I�*A�	�\"�NI��P��3w����?�A\n\"J��\")�ވ���r]-{2�؄EҰj)H�d�:ϭ��M.�.OL��\\w3���#��hb\\Q*���O���8Ȩ�҉+��-�41H��S#2l���܏��ӻ��=r�Z��=���>e���|�ϳ�اq�/!?���X���<3��t\"�@,E0Ut\"d�(�3]��?�+BBCg��'?���Zd�0�S0(z�E�\"7a5q6���4b�F��	K+k@b�#r�H*�Hf�+-}+��r�.үI��A�YB��(SUK'�?Cw:dJoH�z��C��FCpzB�L�L���oD��t_1siG�]E߫)+P�q�=�1�\r~�T�2��%4�>��Q��S�Q�GQ���.`@U+6oSKC��KF�tU�4�x��/yU#K5&�u\0007e/O��w!UCRT�Ԣ��o=59X�15o/�Y��H5o'N��u���UL10��}[T�D�Y(2Y�1u��0���VT�5��P�^5&g)L]�6��-W#N�F����-�QJ��v����E��FP�\\ETS�&0aN�]#N~TB�O�)���G�x\\R_Z5�G0r�+H�ا��E*�*� ��\0�q\"rP�5��}M��T�@�(w�/2GPA���\\,\n��� p�M\\��]k/^!qv���6������f޼�hh���qLE�Ͱ�2�X�4���dP��g�0�|)�U5�fv�Tvla��i<�z~��a��{�<o��u�T��8��T�pq5v��e�tmi	p�?���e�R��t+M/����#��1y��S�w�������0�xl,�j![j��Q�:\rMV2�^w���A�T�l�5b�[o���<�Ƿlo�6�c;s�rI|�������F�NM],����6�WC5Ț3�pyW�i�V�lxR�w�K�'Ӛ*��(���bt㮖#{�|N0�N�c�O�1G�7MH�3�,k|��Ud�x��`�/��K\n)ɬ���\0��x����R��jd2\r��b��@ҭ�;P��Ir�վ���vJ�%*F�� `";
			break;
		case"ko":
			$g = "�E��dH�ڕL@����؊Z��h�R�?	E�30�شD���c�:��!#�t+�B�u�Ӑd��<�LJ����N\$�H��iBvr�Z��2X�\\,S�\n�%�ɖ��\n�؞VA�*zc�*��D���0��cA��n8ȡ�R`�M�i��XZ:�	J���>��]��ñN������,�	�v%�qU�Y7�D�	�� 7����i6L�S���:�����h4�N���P +�[�G�bu,�ݔ#������^�hA?�IR���(�X E=i��g̫z	��[*K��XvEH*��[b;��\0�9Cx䠈�#�0�mx�7����:��8BQ\0�c�\$22K����12J�a�X/�*R�P\n� �N��H��j����I^\\#��ǭl�u���<H40	���J��:�bv���Ds�!�\"�&�ӑ�B DS*M��j��M Tn�PP�乍̐BPp�D��9Qc(��Ø�7�*	�U)q;+����v����!�<�u�B&��/����e4�\\��[�u�DD�\\T�4�TUHt�E��^u�;dH�	�Z�ev��\\��v��d# ��A�7�1D8D��@0�cyM>�\0�wB�0׎�K����QC X���9�0z\r��8a�^��\\0�Wd'	�x�7�8��axD��l\$׾�4\$6�����}OT�=SA[�aBXJ�i��\0��^1z��Yj�9[O�/9NF&%\$n\n��7>�<���9`�Ys��K�5z�^��YRL���u����S���\"b��6D��6�*�BiQ��A؜/�!��D��QP���*u�f�����j�ĵ.o	2r�Z����767ԄB1�#s�(��9T����/:���Y�e��j���v�E!�S��� _/����w�@z][O����:��ي�WF%����1�1BQ�6A'\0`�h�-T�E�W��\n�YV�G����s`)�#NjW�Q��3�ا���,�tM�0y�g��<�\0�C��_a�ǂ\0��9�l<:(zC8a>��)�\0@��pu8��9���a��b@��0��1�d@�\0\\y�	\nj&&��FJZBH��d%a�6\n����t�����tń���SA�v�V��cLq�2D�\$s'L����6�ã>f@�S������TB�������!�xb��y!O����0qT�.f5��X�,bJL1v2���d!ݑ�P܃�s(eL�K)�4��4	!�8���ä��.w�v�o�a\rl� �w<%��F�\\&��\$7\r�|J�8(ly�ׇ!�{q!�d\"���|Dy\$��\nq��D!�w�\0�4g�ira��#4j��ɠ4IP�\0��4<`�@R��x��LF2��S,�x��Ĭ���r�~σhm�����z�CzrP���A�;�8�SETb���?.z����_������N;8\r��-0�^��w9�4Ep��� ���׼�Nx�L��a������Ie,�,dM�h��x��x@ҙ�2\$�Ty��@s	!А�GC�(����B���7�P8�P�2\r�2o.��CGC4��\"svPB�O\naP��1h�*Bw-b����ziL��YW�T�ҞTm�������,Q�/Qj�R&Tv_*h��t\">BsT�i���Y+�����n��0T�5���؉b�кW9�&_�ȸbئA�\\��O	��*�\0�B�EX�@�.Az�y&��n,�K%b�O�׀V���E��� �	��;|b_�q�k��,�,��(�%�͢_<ܪ�{��|�\n9l*�@{pQ���Ra����,�s�H�ݲ��(�Iz�2�}�*&�t�\0��h�)%�wE**�>�T�M�TZU�����Y/F�j���n�Z�\n1g�4��-V'dZr�L2���X����¹8:��ƙ�lf�m�(wi�>\0���%2��\$�ak�!b�_SU;Ė���'������Wݞ���p8�_�����=��/-��+�O����@uy\0Tc�Q���\"��MI�dh縀�\nc��V\0�\0�BH5��:ڍ}�^u���~��S�#����n/�t�����*�H��0;Rj�L��S��DI&�|��\"�2��4����M�g?�Z�.�%��nJ�צ�L���\$����&2�ܥ���ZKɉ>)GjT�C�o��Vj�6G�h�����\r�-^��,N�OB��/Bj��_�\"e����ٱ�a\"��WG?:�V\$ɱ�2�\\�5�@�����e����Q����-���PT�^l@�ϧ�6����?��i�6M1}e����׿O�n��J@�.���1&�W�|n���f�H4B �I0�>T�j*�*�/�ɰ���A������F���L�m���K����\$�10\n�����a��XJ�t��\n�N�\0�����A|2�.��l��[�l�����ͭ!\n�N��R����G���Ѐ����ڃ�οNc���T�����`2�r��8��@Ge���*n�3�.�/��ldƂ�����\rP�߱\"�KWPW���0�Ь��	�\0000f���)mD\"V+�:)�p�N �����%bU�\0,�^�B·�!���<l��P=l��L��3��\n�iB�,+�+1���l�0�8�F��g�-�G��-�q\r��MK����MMan*O��������1����J�l��0�D%�s\"�X�`;�\"j{#��>+rl�L�\r�J�;\$�V���<'���H��%�:�c ��'rR�%�p2'1xVD��\0:P�b�,!R�)�5C�*gj�p�Q��r�V�[*����i�\n@�T���M.4�q�!��L�Kb<�N�)/�2��R�WD�/�V;,r�-s)�V2~���,\0�)*R�2S�#�.M�1����<)�'�/4�\"(!D���Q.���-30�r�R�@�C\n�]G��ƃBvS�-��<��B����P����F��#�.����S�f�n�\nn��ӿ#&�����o�3��h�\r�V� �`�Q�_�\$r���@޸`̇�( �àڑ\$@�h�\n���Z�+�>�������#�\$j���0sM&�P1�P@�A �Ae��d��C,3��D�GϘ	��l�C�9`H�Hm�D�`+��\"\n��u>��Q�ay\0(Gh���8�IEQ��0�%g��3�W�LO�����,\n� 7�X5�\$�VQ���%���R�C�L� -�lGLuC\0���l�p^{�hK�.@a8u��\n����\r��)#��TLJ�m#�8�Ůi�j��nT�8�,'�lJ���\\l�1'6�3�G�\r�\\�j8�s*�ZNbP�opL�@�EnH`t�aB>\0";
			break;
		case"lt":
			$g = "T4��FH�%���(�e8NǓY�@�W�̦á�@f�\r��Q4�k9�M�a���Ō��!�^-	Nd)!Ba����S9�lt:��F �0��cA��n8��Ui0���#I��n�P!�D�@l2����Kg\$)L�=&:\nb+�u����l�F0j���o:�\r#(��8Yƛ���/:E����@t4M���HI��'S9���P춛h��b&Nq���|�J��PV�u��o���^<k4�9`��\$�g,�#H(�,1XI�3&�U7��sp��r9X�C	�X�2�k>�6�cF8,c�@��c��#�:���Lͮ.X@��0Xض#�r�Y�#�z���\"��*ZH*�C�����д#R�Ӎ(��)�h\"��<���\r��b	 �� �2�C+����\n�5�Hh�2��l��)`P��5��J,o��ֲ������(��H�:����Š��2�n��'���m)KP�%�_\r鬚���tv�K`(P�H�:�����4#�]Ӵ���-B�6��A(0(��!\0�1�l�R��U����l����0�j�\0yf\r0��C@�:�t���5}b9���!|g�C ^'A�ڱ��8̱�h���|�#��5��%(�ʢ�\"�!�0��X��+����=�Ï����䍸(sf���P®-B�m;�hJ2K��9�r��&{�gC���)`�!��K�������ЄH�1�Ԩ�1�\0�c�`�2�X.���\0�1��~�3���0�#*�����n9B�4��*WG��RT���� �BbU�鱋��3�4h2�#�V��`��͈`�0���&�,6m���+���P��c+�Y�t�ILe\"_8�Ø�4Pا��������`����\r2K��W�@ӃK6��(h�6���\"�Lf�z�ߩe��j>��B��	�mg��8dQ��\r�3�b��)UA���@�E�Xn.�:�Ux��3c-ἳ'U�����,�l���`��e��\$���;A%�)� �i�y-�'PLб�%%����ܞ�5N�\$nr� Jb����%@���X��5\0ܑy�>\$�}��]A����h�4�JC\"�ZfIk-�����\\A�r.b��R�\r������\"�>�����L��\r�XK��`{������_%p�2�FIU\"�]�=x�`�\r�z���j������\\+�r�9�Z�NI�;I��Ápk�X&t�j�@��!��ÔjRb	#�\"��ys�����N!�h�4�Uw#��tL���ڗ��a��߫x>�a�\$P�|��N�`aK�����Xb&-e�fM@CHo�e���0e�ܬ��-.��������u\r@PCN�1��6���3�� �K�Q�Yn�7�ytC��6�\$z�ʂ̽⊕4h*<Ì���\"*�P����WY�6Z3��j^\\�,�j~Vj(�C)\$\n���#9�I�I+%���;UXj;E�(�#���I��TdԚʓLN�y&AY�T��(ng��`���?!�8�edj�\$K���\"g� PVE��J`�¥Y.&4<�/����O�ǆ�0����Y�R�b*�1eb�\r��`p���CV`@z�}M\"\\�1[����Cc��`�Lb:}\n��ڤ�C�5�p��BqI:SS�<�Y>�C�h�(�#�W1gu\r|)���'Vk��=Q�9�~q\n�J�|��4C�q���>�B%�\";v�Ǒ��+�r+��8G�z�.�Q�y*�s�G}f?�*�^��{\r��^DKC�.Q�M�|��N[l�熷��_�Xe*p7���b��/%�%�s����Ql��ܡ �aI�pJjaL��g���M���pIzAG�/J0\\%��L��������~M��>�b���=/Y�'g��C�h.���aA(�i�l�p�v{!���ꃛh��}w����PK�P���R\0JˁdnJ�Z?JE\r�<����x�)�H���L2g���̮\\͙b�~K�)=�:���ntW���#\0+���O�]�շᛟ��Q���C	\0���\$l������^�k�ID��6�|�s>e��9�3��O>�f0Y��d�Va�\$��Y\"N���::���z9.�\"���R�)�yG#�K�un�/��Z:}w��4Q�gd�F6��ΗKQ#���;�r�;�i6]��tϼ|�+X��:�}����W��\\�\n?!���s��ń��#�1�=@�Ϫ�,\0�%!^�,�t9���\"\n�\\�8󱉬�x�ḫ������M�s\\�`,&��q���~�>T�0x���7��\n5�:�sM�ߌ~�\\�B�֥�_~�P%�'P���� o��m���R�lXq���/\"+��\0Kn%���mPqPz��J Ā7Æb\r��;\0�dDO�7dD3\$�DDŐ\rp�͞�\"P��\"��:5�gG��Ƙ\0Ps\"l,��MHRl�ˇ�Y��;��P��o��\n\$��G�����|⌯	����O(\0������z�н������(w/K��n�������L0��-O/�p�pl�'���/&�s.��dIK��m�<kJ�/T\"/��#p�Q:a?�D��8%�گк}J4�M�J�07�:��{��	�,�r�<k\"#�#���:���Qv\$���	ZB��b��d�~���q�>(�QI�<i���O�d��SEG���αl>#\r�c��̯Q��B���dU��ͬޤ��;c�+m\r,���\"� �\${���/�c���� ��#��S�ʰ��TiB,#�!�\"�T�t6c�#��q!�\rM}�P�'�� �|x��#��n�(��a\n�&��bπ��{(�=*2U�)�.9��+k�zi�F0��0H0�}R�\r(\$��8���Ù\$�F-�̿!�諒�-/�-�G��~Q������0��/2)1m�P����\0004��./*��>��	��-RZJ�jF�lQ/�,3/q�4�r&G��11�5�M2qb\0���/��(�y�)� f&/�|32�0\" s��}9���``�g)��8��S�9�M-�D�s�gno�D	Ư;�EU��1�����S�%��`��`Ɓ��\rd�>��l�*k�&�̃c�'��\r�b��V\n���ZԎ�*�I=�T��|��8#�<��>N�D�G\rb#2K���L�#����	�#7 �p �+��8�4܀�,b�/e`8��c��aC�3d*�T|96����r ޽e��J, �K42Sb\\Q��A��ۤhL�X��lldԯ�{�r��s0u�P�����P�����B�T�\0H`\"�pS�KPT�/1B̀�L�2d���b\r�rm�\$�NC�c͒O��of9��Ft�mG\0��D��|�vs\\J�<&��%�1P/���F����\r�	�.V�=��-X����%�&�p\n��D%EO�}DL��A\n�l�~̋[&�P��\r���.e\"�� k�I�`�\n2)����?��";
			break;
		case"ms":
			$g = "A7\"���t4��BQp�� 9���S	�@n0�Mb4d� 3�d&�p(�=G#�i��s4�N����n3����0r5����h	Nd))W�F��SQ��%���h5\r��Q��s7�Pca�T4� f�\$RH\n*���(1��A7[�0!��i9�`J��Xe6��鱤@k2�!�)��Bɝ/���Bk4���C%�A�4�Js.g��@��	�œ��oF�6�sB�������e9NyCJ|y�`J#h(�G�uH�>�T�k7������r��\"����:7�Nqs|[�8z,��c�����*��<�⌤h���7���)�Z���\"��íBR|� ���3��P�7��z�0��Z��%����p����\n����,X�0�P��>�c�x@�I2[�'I�(��ɂ�ĤҀ䌸�; \n*��0\"sz��4P�B[�(�b(�G�\n�ݠC��&\r�˒�T��l��# �Ժ���?ì(c��&	�>o��;�#��7���؃@�@X��9�0z\r��8a�^��\\�Q�s�=�8^��%Z9�xD��k���#3ޖ�Hx�!�J(\r+lf�̃\n\n�(H;�5�C��᠗T`��j8@�.�P�禌0�\n�T�\"!(�.x�a�z\"%��5X����r�4�5H�\\���0��u�sB3��L�2EZ\$3�!� Rw�j[8\nn�&3�p��\"B�8����(Nz_F%�p��<-�ۣ)�QFK�B�)�\"`ߨ R`�0+���ǹC�?_0�0��ȣ������z������bγ��\0�C�\"��g!G����t�M�C��4��d?F (��'#x�3-�2KC2�2)y\n���	�N�76�C��Δj�#sBr��uza�K�N3��+{�x��R�����7b�)���#@\\6p^�7OÓ\n�ǎl��(ާg�3�`aN�t&�t�PI�H3	|�DNyb�X�AW�6�[��4&�X�f�U��Wj�_���r�>%e��^I\r%�i-R|�-[���,s�ztRʥ�2W���C�k���\$����Oĵ�&e����t}pv�ep���X	bB���R�J�a-B����#��@׹I?pl��P�Sр:��Bnϱ0D��;��Hf0t4p���T���������aa�3��r�Ҝ�ԏ��jA�TϚJ�C�դ8~�6%��\\���j���)�H\n�����\ndqh,�y���U�ט�Xݙ��Q� ��>`�Tdq='�M�H��:L�:`���\n��y�T�`7E��P:Ж!�4�2���:���[��I+�OsQ5�A�0eN��6&8I��FM�Db�H��C\0(%1��gy��Ͻ�ȵ����TA(TD)2�R�y�3��lR2s\n<)�H�#C�?H����ƹNb} g�	�v�a�O��=�`��e��苑�6GW+�l�1O�\"���2�*L�hm�y�&Y6�roL�W(jt3����J4�A<'\0� A\n���P�B`E�h�5�v*L�\$TM��%��q�NG�ᕺE�&*��'�S#��\n_Q2Y?�c��z3�!'{v�B{T>j��t\\U�\$� �;-�Hs-�ͷG)oҫIt��`�{�K1���גd�h��V:(���c�����\"eG�\n��D���┗I�n�趀��d!�i��\\6bP�CJ_-�A�2����#~4���uƽ�etPD��g�M��x]xlֵ�@dm� �Æ��M�����|d4^� U�2���ِO�����ѭ哤�UIBQM}2�W�j�\"�()*�R�L<�3�&�9V�ӀQ�@<�b�qdѐ�����\"�L q�a�<����0������'e��r\\M�{0ȒS��]%�m��?G��r�vIh�.OC����sYi������M)��2\"Dȭm#D�r�*�F6]p#��Q3�Q-�0%:��Pj3�{�t�s6��:V]��\\���]g05n��ゞ�^�2��F�sI��_�B�/�vAHm���DF�0s5���ęÑ�y���?�\$u��Zq�]�	ݯ\$���p^2oȩ%MQQ�a�i��s%\rȷb{�J��\n;n5R�3w�ҩ]=�s5W�:3\$e+� �]#�U,Dg��f4Ł\0(3�a��Run�q�Iϔ�E�5���Wg��\"����-��b�>��\"�rsWO�Q~�p͓�vb����׉�}������sm'��y}C�t�O�ڢ���&�����v��b�\r=g�zl�c=�����������ɍi�!38dL��_}o�c\$(U~E�29�'c�� ?�7�\rPwߜNΉU*S]�_Oc1��K���B��2��,�[y~�e�q��}��kC�]o���tF���#����������(��p� �Bx�-�x(:��M�\r,�\"b��c�1�!ԩ\"�&��?G�c�2�2B\$~͌ܟP-���)a,]�4�b��Va��b�\0�5���8e��	��,�h�c @\nC�h��h������âf�s���P�^0�o-�\r�m\n�I0��o�O	\rLc0�\"��������p�f/Mq�*���	�P�D��@�F���0��A���'�N�I-\0f�i*��������>l:b����݂��\\0& >��K�j>��:'��b|!\r\$T��\rJ�D�d>\r�Vb�g~�Te @��X�C*�3��TW��,�h\n���ZJ�OB�\0q��Q��(Nj�-p�\$�ȣ�	������UpԵ����2\"�t���(��GH��(���V_\\���*��Q�vѐ_X��,g���NJÏdtGR�W&N�B'c&�<�Pu'�O��6&n9&Dh6�X_p�����\r��O�~��n��i�r묂΂�h�j� \n�.�P	�M(r�;�ؘfP1��;�4-��%� 2j9���+��&R;R�2�0 �à�9����%e�0����>�~q��";
			break;
		case"nl":
			$g = "W2�N�������)�~\n��fa�O7M�s)��j5�FS���n2�X!��o0���p(�a<M�Sl��e�2�t�I&���#y��+Nb)̅5!Q��q�;�9��`1ƃQ��p9 &pQ��i3�M�`(��ɤf˔�Y;�M`����@�߰���\n,�ঃ	�Xn7�s�����4'S���,:*R�	��5'�t)<_u�������FĜ������'5����>2��v�t+CN��6D�Ͼ��G#��U7�~	ʘr��({S	�X2'�@��m`� c��9��Ț�Oc�.N��c��(�j��*����%\n2J�c�2D�b��O[چJPʙ���a�hl8:#�H�\$�#\"���:���:�0�1p@�,	�,' NK���j���P��6��J.�|Җ*�c�8��\0ұF\"b>��o�������2��P�����%n��B���4�l3O�\0\$��x����Ԋ9�r91\r�  ��j�PA��4RCI��åL���سH�pd臎����EJ��t�㽴&5r��.�8^���E����#R��3.�j�;���^0�Ѓ �\rʛ��i\\\\�1�*:=��:�@P����Os<ͪ;�\rأ�'+î\"4�t����ȰJ��C�V��U#�p���H�(�0�CrL�Uc�UY���SL�(�0��b;#`�2�q#�v�1�K\"-'�Z��i�4��\"̗��C2��Td5��\n3�u^�#�#h�%���ފb��65��%J.�K\"7��-0�P�5CRt#��C��Ȋ|��^Z���X;�yB��I�����X\"\"��e�b�f1в-w �L�)ӌ PשiXk2���`�3l�zj*��A��	8�_���]Y#6��#k������3ʊ*��%6�|2��R�T��ȼ��1>9`�r�Xa!�9�<�a]�y�R6vҹ\$7����8|J� ��3�X��i�i�4�`@�H2�ZKQk-����U�9.%Ȁ�t^��D橗��zlD�,��TJ��m��g�\$c�D��Ǭeɺ|8��T:�R�;���g�hfS��[kv��¸�r�C�j!����K�.L�:D�|���%,��CW�{gD�C��H�	�D�*J!�BH��\n�\\5vx��#4D6&\"RC3V�}]�'t��z�\r�R5K.&L�4��b_�u���dR���� \n (Ft�%��=���\0PU_�\nfḽ�uz��i4���\$T͚�i�����13���//�,��k(�\$PW��+��/	az�� ��JC��Rn��)B�B����rrN��I'\r�\"F��pt��4�JUI�I\"���(Z��q&r,�4\\Z{q�0��xwB\n(c%�؛4G	�P	�L*�|u͙P)e6�@S\\�z��d�zoU�a8����\$�T�XnG���/0�M^]B気�|��ph�5S����+eE׫v@*a�A��P�]�)x(�1A\0�Va�b\"�8P�T��@�-�Lė���B�ԗ�\nۀ��Lۢe71	#�d2�́�'�'���].laǈ�6C�=�������8�I%�#�8�u����G][��י݆�\nc�TH�+I�`��&I��(��BQ\"q�3JjMi��UY'T��\\�G� 4Z1'1���cɅP���N\$�B۪�`�U@k�u���U/��9j:k˻MÓ�҆P�Ø�0jl���\"�	�>(��Ʉ\"�s!?/����#e�@g�a��wx�����3,�Î�r�\n\n@��2�G��\nz��ǰܠ��b�(�\$p���tj)��{�(T\n�!��APj\"W	YZ P��SSX�D �D	H/`��XJL��\n-?KF@X	��:,����\r{�P	�d5�����~�Q�+�pv%�Ff�@��a��Ĩ�f�.�t��@��9�u�����C�E,�������U��q�OJ����E��+E5�L6׼�-�����H���&�Ԣ��(C@Q\0\\�\"��JJ�����t�cU��1�S��׃�0%�ȗ���əR�%H������#K����@��қ檔�,�UΔ\"q5K�����`��8���s����;�[XO�son���l��`��w�D)����r�Y���1H�q�g��>ީ���魳��zJ���fD�72V\n@PN9���uyύX\$���y,�y�5��%�W|\$�Q���x���s�;���sPr\n��Rdo�oWA�:�=�5֝\rZ���ݷ�}߽�ٷ�?�p�����B�� Ag:O���R�}|������w�y��V28-I�Ď���d�8M0��p�B�`fC��\"\$i@\r@�:%`#B2b��.T���2���oޙ#��\"��:5�?��\"N�L��m.�\":0B:�g,f�Kj;�2&����qN�0fb/��n������XI?��&�|gP��Φ�.:����B���	���Ù����\0;�Lv.,q�6�\\mn�`ef��25@�\r#��Ot΄�Nr����	P����/�jf�n�%\n���0�ɥ������x����'TI����P����٫����,�����*i�.�/d/:P�:%�JTQJ� �f��Ns/���QV<�e�V���~��C	@�oX��/��\n���аk��'D�\n��=с0lB,���Q�Q�T�/�8bU@�X��1�&i\$ǆ!f�e�G\r��5.�1��q��\"Jq�<���WNe��5Fv/�����ӆ@P�b�m�\"`�*p�@�a\0�`�#�Bq�:8N���'�d!M�92��4�X'f�G�\n���Z��g�T�jՎ49\"R#�~��b -�ۍB(���\r|�%q6#4(\">\$0HwB�_���\0�\r���.uB��\0�C\"BC��\$ E-C�D�%@�%�N8�aB>�c.	�����|ްַ)�x�x�&�Ĕ�(\$��g`��B:0��*�(�0s1)�8�\\E�Fh��2�sP�+�6�\$�)�341�5��*c8�F8R'Lg3�P83Bb,k��}�e4���L�FnK�n���T��9�2�R׃����ae\n�bt�C��\0�:��PR���t)�6a����V/�~T\r4b�@N�WQG~L��1b,f �+�R\r��.�C\"f|�΂�7����TJ �	\0t	��@�\n`";
			break;
		case"no":
			$g = "E9�Q��k5�NC�P�\\33AAD����eA�\"a��t����l��\\�u6��x��A%���k����l9�!B)̅)#I̦��Zi�¨q�,�@\nFC1��l7AGCy�o9L�q��\n\$�������?6B�%#)��\n̳h�Z�r��&K�(�6�nW��mj4`�q���e>�䶁\rKM7'�*\\^�w6^MҒa��>mv�>��t��4�	����j���	�L��w;i��y�`N-1�B9{�Sq��o;�!G+D��a:]�у!�ˢ��gY��8#Ø��H�֍�R>O���6Lb�ͨ����)�2,��\"���8�������	ɀ��=� @�CH�צּL�	��;!N��2����*���h\n�%#\n,�&��@7 �|��*	�)�*���R��<HR�;\r�P�\0��s��(-˖ޭ�h��2(���\r�Z�# ڶ(o��?(+�8?Ј�1��2��S������:\rx��!\09�P X�(П��D4&À��x�]��]��Ar�3��X_S�#���J(|6���3-�g-�x�@��z2N`P�� ��:���Եc��2��U��#�`���ˈŁB��9\r�`�9��\$<�\0HK�XC�>\n�Pˈ\r�|��\rF7��Z}��p�3#����p���`�ȪZ5KL\0�0�*^P:`+����@�3�k2�d����W�KS��y\$��r>��`\$2C\$�f��^�����0\"���k,���M0���H�wy]��4�\n5�C+\"	�,�p�0�9^Ϙ�����w/+[\0\$���~��o=��.�}�� U��΢ ���}ǂH�F2�����	���5\"��6ƪ��;{Q�x�O��*��t�͕#��U�w�l0��*��W��aJR*���ؿR��)��ߩh@�5.�L��#!�0C��yL\$bHA�%!P45sD�uR��B����Z �0���@��:�V��[+�t��X+\rb��^}Kj׆��C������%#L����a;9�;P܂X�N��80���)%eD9Ր�\nl�1*,��\\�!R�V��]�uz����Kc%T��a��s����BA�E���\r)����՘����K�-�\"�F�	�6#��dtjܙ��*�X&fT�:S���V��/`��3%��UC�\r�d���<�	��l��3�\$�InCF���F���u.35�9\nN�Ě��@\$\0[3ѱ?(&�PSQ�2���(<�����c&j]���)s����.E[�w/������`T�`kMj��q��R#&�R�4\0��ZA�8*5L�P�S��4�0����.�b����a.&E��`�O�)��3J�\0�iK�-�!�RH�yxE��(�����'�ŗ���{	��T��5Pf\n�@̤B>i\\�.R4���| e�֖4�JZ�/�͂{8���C-�-`κht\"/��#Ox\$c� k2Dp�rDI�g !M��M.�r��P(#4��Z|�.�^����R�C#�A��@g\\�ihA<'\0� A\n��[ЈB`E�lA�'�t����Kɭ6�^nfwY�N�}�4\r�a�;�y�7��@z\nq�ˬy�:!�*@C	0���	&�V�N����ꛏaAU\$�e�2o�:>+��%*{C��L� �nM��4R�	��'�\nYp�EA�z�T�TkG԰&(]��_\r!���:���2d��^g�����v4�/L��2�^�w���Iq1���7���\$�x&�b޼�D�7���\"�m�-�P����nsU�De����d�)m`��V|�\rd�IQ�%��R�q��\"s�p��Aa UB�衫��=��VhI97��*�[�X �_X���6�0.�F�a�	�-U�S��2�D&,��xٵ��b�P�.�ٕ����[	� 'h�Ǒ�l���\0�l ��� �2�r����Șj���4�s�{�)*���?������㑘#:I���(���\0�(b����j�T��<B��8_I.�-��1�RI��]-���b����E���.��� 7�X��c:������0��	�e::\$��y]{�B�Rק[��x��wc��x��)hb��\n����#��Hbo7�B��4����3}��x��ZYK��e���:�}�~8���Ws'�\rp���}�Ss���~����������IM1���ʝ��:Wg�~��y]��>�I�^s�+�����|e�N�-�2y���6����\$4�\$~���?_���~��f��2g��:���.ٴB��}���7�b~���o��gp�Ǡ�������N��\ng�^��,�V��4�<Gb�)���\r�4�wf�@�Udh�\$0i#�d�'�D͐)������fz���-���^��+�͐F�,�^�5��Ά��ʰ�\0.�6�lQ���E�� ����\$����O�\0�P���ϝ\rDD_�\r�Fd��L���	t\r��'�.��Z:��Oα�\$/mB�\nO�\rJf�KQ;`�( �w�.��Nz��\$�C	�-\0/��7�,0\"�v�{	�@���t��0Qb)q[	��9qq\rqh?Q|K(b��*Ei���e1@9�&b��8��*N�.�#Ap����l�:Ѣ3��0\0�Fƾ�\0D����MI���1^l\0�3-&.�ڞ��sC�΂�A�tSf��1DR��������%*(d%\"P�	f\$`�d\r��ee�4d���aJ�R(��I�T�`�D`�`�A\"� �ڑ��X��.�c#V���\n��r�#�\r�%2N�\r�tn��/�*KP�)&א8��.gP6P��~�%�C���c�!@Z�1'�O'ΐC�N�k`:dE��\\#j���+nK�.	�m�c��5�^�%>T��n'>�S#�J�p��#b��M2n ��,�c\\�q��sR�4\$Bf2,��0\r\nj��-T^�r%R@���.���e���J�侓q\$��fg6\"�*:-��� �p�,�\0:�G2�J�9MR2Q�/Fb�ȋ!4�\0���Ҽ1mRF�,#��8b֓DjF�.\r ";
			break;
		case"pl":
			$g = "C=D�)��eb��)��e7�BQp�� 9���s�����\r&����yb������ob�\$Gs(�M0��g�i��n0�!�Sa�`�b!�29)�V%9���	�Y 4���I��0��cA��n8��X1�b2���i�<\n!Gj�C\r��6\"�'C��D7�8k��@r2юFF��6�Վ���Z�B��.�j4� �U��i�'\n���v7v;=��SF7&�A�<�؉����r���Z��p��k'��z\n*�κ\0Q+�5Ə&(y���7�����r7���C\r��0�c+D7��`�:#�����\09���ȩ�{�<e��m(�2��Z��Nx��! t*\n����-򴇫�P�ȠϢ�*#��j3<�� P�:��;�=C�;���#�\0/J�9I����B8�7�#��0���6@J�@���\0�4E���9N.8���Ø�7�)����@P���mc���B�N�Oc ����\$@	H޼2�D�9#Cv6\r�;�=9nhº�k�Y\0�cUJ ���?:4p+�<C�9A�1����3�\n�@:\rx�^�p|\"Ʌ�\0x�����C@�:�t���5�������|9��^*�^�7�p������7�x�*cx�0�4ܳ1�[����`-.�J�hf\$�T���b�%J'>� ����,J�:2��3:9�l58Y�j�猨�	cx�\$(�{�L���B\r���#p��I.]^(��F6��\"�xZbë�ӭ�\n9W�%=b,X3����\r��)��(��q\n1����:0�H��0��0�R\0�|��'�:��%0�B���������5�k�@B��&P8�������X��M��Ow� �����:v�܌y\r迹��S�80�h��Q㤅Ih@P�6�|`��}>_����eKC���È^��������:`(6&#�AH9	Ma�3\$>M��yT\n��#D�IY-�N�C*�>�x0�V:���An���2�Ε��9`��`�\n�e�o�4A�g!�.И�B�Y\nԉ SP�+,��\r!�8�Pq��耨a����¤�PKf��:`�C���X;�\"�Ȁ aL)`\\�E���6�2RP��A�:��^\\�C݂J,:�V��	'�<����I#`�ρ\rD\$��'��<7����L�oB�ek-�����\\K�su�(O��^A��2�����ƌ��2�X96QJ����=��JpMQ��/\"Ila��̔�������'DJ�t�1�k��V��[�q�U�-�\\�K�8K�ʝȂz�+�9��d_Bhk&5L�|P��s\r�B��bP�PZ���g�5�Q%���j��(t�&��4}\$ ���\0��6\n��b�9��i\r��� \"�If��3t�x������PVa����S�&�iZqv\r����H�_�(u@(b��҇˝gDȡ�Sp��	y1&e��8:��MJOy*IX\\�����\0Sib4gXL��N1D\r��ѐ�А��;�2���H%-%��S4d�I�8e�!�5��hÐA�����²�H�X�� \$�Z�j�BE4��]C:ި�0�[)8PE��%(�E��;p�N��\$����/��-�.sӉ6	D ^�!P���(Ց�ğr��i*s�MaNMg�7�G�4�\"\$�JX���\n��\r�W	����Uh��SMa2N��\rא\0�U���\"�5��EF*����,L/���r@�V�C�������\0�+�Lf�N�>��C�i6	m���Z���;����\0��B�� (82B�]T��H�t���ڱ0cL�9L��ZњA�ϒ�ϲ���h�q�ǘ���9�1t���uv�y�4!�q��K�.���PY���x�%�̤���2V��S^ŗ9T_	M�\n���؉�B�x��;����S���:@ް��w���2�a�Wc���\$ꦤ�Ϣ��O��8@��oEe@��&�g\n���=��9�Fƹ4cr�Q���M�9�)��w�i��I4�i�l�1����iQeϱ�<p��\n\nx���7�Ej����hR�,'F�b���mT�C(�Ō�Ct�n\\.Xn��	!��������2KD\n��\\d.�m�]��iC�r F�����LUjL��&��&�Ian��:�@B�T!\$��KC�=�z��+\0���u�|:�6j��:ehI��\"��ϕ�fOi?H#i��zH�\"Z�M�޻�K˙8�绯�>��I�\$�/��Z�3_6`�z>�++٧�G����<���}�u!�၍�/�PS	����{B�����������C񏟽��\n݀����7��?��k�	\"��qA�{��ȈZ���#B8�p*�@�\$���\nNB0QiD�D^ML�DP<\0���L\n�\0BH7d� \"z���͌�K(n�F�cT�B�\$�V0@	\0?\$Ȃ\$�l\$�0#8� \"\rc���X��JD0<B>U(�PO�	Mq	��b@�'�4��m	\$MN7	d��t�0��B�������b�(0�\n���o�����C�?.6(�ϧV߃`t��4i<kl>l�@o�-���8*\$\n^8CN���x9&��l�A�64�`\n�*(��|���Bw��oT���Oh��\r�Vj�g4\$�\rf~����	�L/��Ї��(y�\\���,B���\r�Zp�\r��S1����/S�\ng�A�	����&z�����	��Y�\n �p:\r�D���b��\r1�Y����t��x��X�q���\0���09 ��P��2���!2%r+ �^��,e���N���#��С%P8�`į��1�&D�%��Y�J���*��:.�T�o��()B�*\$�\$DV���tc�-e�Ab%��PZC�bG\nF@e�)J��n���S*,-�����Kb�x\$[DN\"g�&rY\rXҎ�nxda�M')Qp��Hc�� 1��E1nM��U0��`�c�J�s)c�2\0�y��cs2��@9�А�	�W2�<נ��+6�R\\DR/6e5q�5�=��763T%��y�䍳s8��JJ(rf�%��=C�8��acď���G>��P��d���Ł#�)&�B�8�2=	p�!!<��=��?.^�\ri�0f4�3��%K4'�.S�?�	4t�B�d��Q#\"&��ۓ��s�B@�B�O>�#7� QT7/-1�q2�@4GB�4S�4W?�yQ�5Ä�D{'�@7.+8b�~��.�'tk=n�ú�m%�G��'ΝGRJ�锖�ԃ8��H�� �5.���|bG'����Ro\"��CN�Hb��S�*)�e�u\"�>R:{C;+���FH3u!���#j�22�)�U��\r5\"Qo�gU*|RR0�6*�S�c1�RL���!/�!hk\"�L��V3�Q�NBU>d�\r�V\rb�#���4�bN m�9�;���C��t)��OBLCb�-��!�_,`�\n���p&�22rn,�A���O�%���5�}�O�i\\o�5�]\\�u%:��@�e,#L���#����~&/8���YG\n�5��\$��E�X�prD.;��sH!�T�#�XX�b5d;�?�\"\0�#����`������2\\ @ޏBc\nOg�gU��K�QahD��\"(�h�6�ߖ�\n�u\rbև�Z�p��^R�NR��51�t�#�n��YC�f�.���W�<\n`���PIJ�h؅6�_dp���2\rG�-���������-k��n�\"�\$W(Q(ҍau��ݶ|��T��K:J�>P�3��t�>f�6�\r��Qd� �5C��R�����{\0ں��OB�%�";
			break;
		case"pt":
			$g = "T2�D��r:OF�(J.��0Q9��7�j���s9�էc)�@e7�&��2f4��SI��.&�	��6��'�I�2d��fsX�l@%9��jT�l 7E�&Z!�8���h5\r��Q��z4��F��i7M�ZԞ�	�&))��8&�̆���X\n\$��py��1~4נ\"���^��&��a�V#'��ٞ2��H���d0�vf�����β�����K\$�Sy��x��`�\\[\rOZ��x���N�-�&�����gM�[�<��7�ES�<�n5���st��I��ܰl0�)\r�T:\"m�<�#�0�;��\"p(.�\0��C#�&���/�K\$a��R����`@5(L�4�cȚ)�ҏ6Q�`7\r*Cd8\$�����jC��Cj��P��r!/\n�\nN��㌯���%r�2���\\��B��C3R�k�\$�	���1-�[�\r@�Ą� �T���T\$A#�2J�D'ҽ@PҀ��J�0�������2t� ��j���|�A���A�ƃ\$:�C;�#�~:ְ�A\nC X� �Ό��D4���9�Ax^;ہtmU\r�8\\��zP���2��(��@�ˢx繡�^0���������S3�>�9M��b��ılk��+�� �&8J�9a�p�7��̺϶�P��HpΊ� @1(H����bcx�:�1�=�LNt���p����r2 ؏���k��2�c��-�ܿ���ǈ��f�@ӱ�(���xk8�cf�V\r�{���L��F�;b�9���U!)�v���kg9�Bƌ[ؓW�z&�\r�x7)\0�(��S�C;�����[AC��m(u8��9�o����]�r\"����PeB��SZ4����(	#l�8�(����V�׬(_u�%\"OO{߁L�I(j�3Fҥ�8�3�] ���2i�*\r�zQ���؇0�Ձu.�Ie�(\0C8a/���E��((`����J\0C\naH#A@�P�YH��M���K׳V%����W�C�2�%��ps�W̛��N~\r��%�y]*��A�[Q2IV,�L���Z�am-�J�@+�s�^R�����F�ry���_�����MQ�aYh=\r!�ا5��4�CŌ�Щ~��u,ŝ��Z�em�տ�r\\��9���sWj�y����x��x I��7�ךH�؞���N	�\$���BH@�R�9���d��P XM��yg�s.!�CD(��4\n�ka�}Rq��ؕ�ɊE��hF2u�\0�JB!x�vK�@PA�P� PTI'+��Ň2<�	 lF�5p�3�ʥqx�3�B:�\r��V\rɟ��N|�bN<���N(aHa~��y�H�H4��P8,I��Q�&R��-I�L�r��(�3��Q�(%��c�q#��\$�W1�HP��6�N�!�ɦb��\$M\"H(,���\\���ney\rb��?���������CA@'�0��*q<N��t��* K��:��\\o�ۉ�!��8vb��é�07L��\"o4U��\"	HѲ�E��:4�<.*O�zˊ+ϖ5�����I84��0�Ec�j.N7���p \n�@\"�n���&[��'?�l���ҁ,b�U�2ufK�O\r�����^Ii�b̢f�b�J���{��pZ�\r!�.*���`��T�p��ު������X�R���=c��]r�O,UG��R�V�e���`�@\n\n���r��I�JМT�Ӧ�}��\0��\\�Q(�#*���U�g!�0�Ga3!\njE/���C]!!�%ҍ���Ô���re�leĨ2�|�fs8��4#��#\\�1f����E�U��.�T6�^��1�����r�=�'�A�M7EC�Ԙ����`ꤵ9�\$��əEi�r+�ܗ&׍�\\7SD��D��tKR\nH�]�BH\r̺���[�py�|���2^m\"�j�����2z\r�͗oA�Nn�Jeq��H�����D3&7^�K9�[��o܁�~��[߂pj�Eg�!��Ւ̟Éa8f�K}*@�I��m��0��hoP���j���~ʣɲj<��r�p���pk��)(ա�1�,���N��P,�U\$n}m�@Dd�(�&U	�Uq]v���Co=!��~�S,M��DEA��co᠛��Bz�eը�k�c�)�V�O:�3hI�\$>�����f\"�aW�|��O3�/�=��fC������2N\"W�os�7�4d����tAF�/C�J�!6	���Lu��?�Ob���9��7S:E4~�A^��qp���:���/޽�\n9�\r��%�a�=%�Xc�4�g	Bb�8�ᶎ������O����'|DBJ�n|L���~�C�0���M��n>�p�\$|�*�n�06�R��>�/�|�d�n,4+�5\rR�fT*æ�/H�p05-U���.�Px�\na��p ��r9�v/,BMb��+�@��6;�I��(�f��F�|/�jD�m\$\$�\0 ntgK�\n.��ⶲ���� �P`KMS���k	\rXG/X�p��mF��h��r\n�� ��qio��\"���gp%�(0C�ُ\$��H(*����S�2�B[�l.M���Rh�Dk�\"(�p�+��Tb2�IH�Ì��(�j�1O-���P,�1�:����qVvKvlN��1�Ҫ%-�ǮCQ�;n�ї�#�k\$2P���Q�aTh�W�v�q����_��%q;J�!0��� %b)\"�P#a�{�\"R@g�\\.�a 6��[rS\$�Yc!�[\$���O��&rT'\"g�hiC��g^M�4� �(D��X'�yE)2`@�0��Πޡ�r�J���G�f�����I��m�p6O|�I�f��e����/o�1�hX#7H��N�Fx�h<@�j�\r&�HD���^B3���N�@���E�,\r�<A��@�\n���q\rF�1fT�PB�k��(T�0�SZ��.��#�xN���Q'%w�1������k&R�)����\rr�� ��B��`e��x�D	��<�(H��tj�®J�#��K��c��� @��1���N6S�CB�'p(QC~��6P�0�@j(�ܐ�{,�?D���?��5����\0��USB�MAks&�6&�L��x��D����n����G�p��Q�� ��]#�#\$��:�M�\"�tm�B��2�%N/\$�1�.�T��s�u<��p`���r�J �.�!\0���J*s�M?e	-pvt@�?`";
			break;
		case"pt-br":
			$g = "V7��j���m̧(1��?	E�30��\n'0�f�\rR 8�g6��e6�㱤�rG%����o��i��h�Xj���2L�SI�p�6�N��Lv>%9��\$\\�n 7F��Z)�\r9���h5\r��Q��z4��F��i7M�����&)A��9\"�*R�Q\$�s��NXH��f��F[���\"��M�Q��'�S���f��s���!�\r4g฽�䧂�f���L�o7T��Y|�%�7RA\\�i�A��_f�������DIA��\$���QT�*��f�y�ܕM8䜈���;�Kn؎��v���9���Ȝ��@35�����z7��ȃ2�k�\nں��R��43����Ґ� �30\n�D�%\r��:�k��Cj�=p3��C!0J�\nC,|�+��/���ϸ�򰘦	\\�Mp���c��˧\"c>�\"������,��\$2S���ҼA#\n������͉�z����z7%h0 ���@�AM����!�#��!\0�@�;�J\0�XBI*9�`@V�CF3��:����x�k�ԕL������ax�	�c ^+�ѻ�p̾'����|�=��귴�&�O+�ۼ���*�cb\rK�	jH��8^�`�@�7���J�B�^7G��C���J�\"��6�\nu�Yt���K�,1�y��5�桪c��C����C��E��Ӡ�ى�S�M�F�j��.(4��&�h��b�B}�73q�xۡN��=*5wO���B��j�bR�M�,1��Vl�*���&L[�>�c( �H[�!Q��qs���9�2��L�\"�tG�tE~�l4����(	#m^��ǆ��ira�1�Uu�R7��!]�]�_7�7�3mSX���x�3\r�\0��,�t7�)����dێc6���O������O��N�S+��\n�)'!P7��VS\nAv�b��JH.\nT��R8���Jg&Ļ3��y�)�d��#��\$o`Y�?F�\"��8 T�l9,f�eʣhY�e�՞�V��Z��l�Ẁ���\r������>�����E�	�,���) ±��C���v�Q��������\nB�24.��LEY�Ai-E���O[��o����]/8V}��p7	8:F��=��}��>�N1�/��[����e6�����'A��+�ㆅi9B���f��Y�W�`���\0�t�Bc�%��Ǚ�8��N�@�(�D��)�E�X\0��xs��RJ�232A̐�LJ	�.\rʀ1�(s(��w�ّ��pp�Z�p��/��6��pdp�AaC1!gx�J��B�l�]��_Ǖ�0c\r��,��'N�C�(�C�U��(E�N�rO��o)	�]S �&p��\0�����T<��HUa%r|���F��24�\"����jDt�.0�	O\naQ\\� OS��#��*����d�8��6�G*�W��گ�2�]��?H�*Ѻ���	'ȆJ��%e%�9rA1\rжK�\0F\n�����*�%j>u�9t�q'DƘ�Wx�E�3����'��@B�D!P\"�ۜ(L�P�&5psك2b�]�^0��<����ka��aBF�(���Ьj-����]��^��G��9�:4�G`�@+`�ڠ����xiV��3/���������b��z,��6��/\r%�������V!l<��u&���¥�y�ag|�+\0)L��ъ>?�a:G�C�C/4l���CHzi�ږ*%�H0dTxpͽgd���HD�;0���R����c>X��\r�Xa�ӳ}ӥs����uf�K�w\r����T��T!���8���i��������}N��P'ʅ��\0�\ni�Ax�Α�z���\n��I�P��Q�@�BH\r�����XUj���U\0��sߋ\nJ̤�ӹ\r4졑��i�i�H���V�b�����w� �{�.4y��ɽ��f�[�~d�2x�'!:s���\nq/����s�!���Ĕ�}��z���r\r�ғ��דΖ�ʌW,z�s����T��\"�RU�RfW�շ!�m��E��l�>����B�Б3H��_/+�W�\$\"`�(b�\\R�S	���I���w�Y�`�4�ݐ�A!=ߒ�ѲaF\\y���#�G\rc�l7�|mw�8m�GuA�+�r�a�>m�o�׆Wi��}`��%o�	G?00��e��0тb^� �Zc}��%�����QGg�o��FndMx��p�&����Zn���T�Z����>�^�i|kA<�h]��<�^��32Bߴi�!N9��nr���+�Iΰ¦���,8��L����>4c�I�;\0�E/�g����{n�P\$�-1� ��p�PNv0R�8�pZu��tӢx2���\0�n��(4O\$4�l��2�Pv�.h�0��o:7 �)���p6\r@���J�T�/\n�<�k��H��w�!𮸭GP`L�x7���bM����,,�,RN!��B6� �hX�|�c�dD#�Z��TR�{�00�G��?��#���Є��(_KN��\n�?0�J�~��nң���\$�'6�LA&d���ǐ�s��\n��v��;\r�:�,Ja�툔}bsEB��H����q�O��f��:���ı�#*�Ƥ�b�q��Tb8�	*����sk����Г�rJ�q���b��J�f���\"�lZ \$�(���2,2\"��|/Dt��D.Ϝo�,/�Z��&�\r�=l��FIU\$�a��W\$�O�m�\n�RI%�='�'RY%Ĭ�3~��X��ip��Ma��\$2|:��/R�������+\n���uR�+�����r�'2����LA-m^\n�*Q�د6�e/2QK�H�G&ѩ.��/1� o4	\r�Ĭ�H]-�)!�6܊!�GT�ݒ*��\$J�*z�GmK�dCb7#0o�2��*CCЍ3s^�o)4��/�c�\r�V� �l�,\r��]�9#�4�l�:����' ����C�1�R\n���Zh�\$�>�:�/�33�2c�>�S��sH##:#�@\$BH��R3>jj���lJѶ\r �\$�1��\"�=��*l�|-j?C�2k��IB\r�q�N7��2���R#ɋM;��\n�SmF(�6�a���7R1�n�F\$��\nte?��!�	���j7�1�h���`�Go]G�T|�4D�M4�5�H��\r��*b��D.�,�9�x�@�C�-Q%?�����˫0EM���F�v�j�8O@�4t	��V �DF�K�D3`�0'�>�31`3d�9C7+�cB�m�&%P@�u.� �@K�@�/���w(MR��J�zJ��33FJ��/��";
			break;
		case"ro":
			$g = "S:���VBl� 9�L�S������BQp����	�@p:�\$\"��c���f���L�L�#��>e�L��1p(�/���i��i�L��I�@-	Nd���e9�%�	��@n��h��|�X\nFC1��l7AFsy�o9B�&�\rن�7F԰�82`u���Z:LFSa�zE2`xHx(�n9�̹�g��I�f;���=,��f��o��NƜ��� :n�N,�h��2YY�N�;���΁� �A�f����2�r'-K��� �!�{��:<�ٸ�\nd& g-�(��0`P�ތ�P�7\rcp�;�)��'�#�-@2\r���1À�+C�*9���Ȟ�˨ބ��:�/a6����2�ā�J�E\nℛ,Jh���P�#Jh����V9#���JA(0���\r,+���ѡ9P�\"����ڐ.����/q�) ���#��x�2��lҦ�i¤/��1G4=C�c,z�i�������2���t�̬Bp���\n��0�B�1T\n��,�7��p8&j(�IH�(���i�/�����㒵*���#��&��û446Vz?ģ���X4<�0z\r��8a�^���\\�)���/8_I��p��xD��j�/c2����x�!�����Έ2���P#���U�h�̥�C�� �`WY.N4�.�\"ɍ����\rb��AN�J+��r�3�h��DcC��c~5�BT0�����ق�:�\"a+��\nC?1L�2��0ح���L�Ӣ# #Z4�C;�\\�����K��70�A°�[��Ƶ;����3�\r������E��\r��o�zä(��\0㹎C�ƌnG9��M�\r9SW�6�wy�z�cE9Vo��D!�8Ί~�����<�����t����\$��:\"�o+��oVn�L���H��z�cB���H��A�#j�D`�)=	\$����¾(��2%��1C\r���.E�\n�F(ŨC�@�@s\$�!�0��\0o\rjH�>BC���<(�f��E���k� f�1�z\r�)�	-0��&k���W�0 ]\r�u��޼W����b/���n�`�1���t1M��X�\r��!\$-R�q�\\�>+�3���]c&F#��I�MB��o�4L��JN<0�0�5Իr�^K�{/�����q_������C�U?�(���NO�����!W�a`1yёʁ����z�r�/\r����G�i;��m:S�ɜBO�,0�i8c�iX�j�q��w	�%CwK�4��LJ	jL�X1f�4�#xu�0c ��H�٬p�[J��ܯ�\n�8&�4����QN9+(����(�\n9K��*b���\"AᰖP�pߢB��Ɗ��X�W�����H\n�����;XL�l�)I�zF�14&����IY�K�5�hr�Ic+\$q/�w&�Qx1 �.M�\r--e>NI�u�(���=e}[0!�\r�c�rQ��%`0���xS\n�Ų�4QO\$;\n���'�QH9 E���Mf�Q	I/ �}*L:���.!iQ�W�(�	;G�\nD�����o)KV�p��\n�97d�#@�G,<6D&Ƨ�r���j�(����Qۧ���3�KS�Jh&��L��me��+��c|�b��X��>�e7������ֆT�\n��-���C�I0 �-\$������{�4f,��*�0�1�\"8F�Z��ʯ \$���l/�\$?Ed�1,e�H�EN��\r��d�P�L�{�*@�`Ģ�-�	%�@\$]򤀢1{P&*�fL�_�z������A��2L`�&\nՓy!n����C�~��z�\\���ȕ�̚?t6��@n�(wN��2��B��.�|Ç��+5=E�V��C&��\r���3=e�[6=OH�Pbf�M+k��`����V�f��3�@\n>�\r�51��2�κ��s0�6�|�I��p(�q�W��&�M�����s�xE'm^�4ա�qצ��g&���Aa!�;eQ�!�C�1S\0�؄ɣ\r���طbҁ\0/��8�~��_%gƸa�p��rB^UZ���xĮ�\0�\\L��x�FG�Rj�ZP�L�YU�N@��Oh�s��	�%�����]�8o@�˫s4�\"p\n}\r[C�ûIg�M�㲐�ـeD�����M>�g��t#:/=�'�\nߨuy�Uk��_���ƻ�.�\n�L8�c�#g��0eY/5���A_9�ɇʳ������(�!	�7�1϶|>�{��ZQ��&ە�rh�?�+G�����QC�G���-R�>�-��_;޼����9~�?�%,}�圷Ŀ�2�����i��A��*B\$�\ntxo0��Ґ��R@���440���U+z���Ղ�������ơ��KB�֐2����M���r�d�-�K �g,t~lz�oĮk�F�\rl�{������(�,a�|�cX�p�xj'��x�'�yG��pr���l�n+P��Ú0��\n0�%x2��0���c�*��J�j���g�Ʈp�\0\r��쮈�\$FI�S�\\���p@kا�н�\n�|4p�����\$=P����k��0�>J�阮��I� �#��Q&*���>M�DK�b h<<�Z���,cĺ]#\\\r��c�;((�mZ&�( [,��1�Ϋ-��\rT��׍bx��M�&�3��Ԧ�sQ:�Q?f]�����q��L˱��p���4�@e�����E\$s\"�o��j!\r�XQ<�.�r\$Bl�b�pes\"�z�C�#\r��l��HP�\$�H\$#���@�;'*'�2p��:��8o(��pp-���/z��w(#�d������q��q��0��� �e\$C�2�J�� H2\$�+�+��kPD&��\$Q6/&�AW\r� ��Aw)q��2�.E%.��)r�2�c2�r�.���q?g}0`�0�.��:�22D�-2�����}Ĵ6��2�4\ry '���no�V!L\"r���ړ_#q\"�g5ć0M4��8hTP�stM�M��%\"@ľ��6�6S�T��6���z\n�����:�'��B���Ҟ��J\nz�< Bf�b�@P�?e�ΈK+�+�8�s�N�>�ʨX�e~:&x�#\"&Ơ������:�l�p���?\"��\r�L5�XP �k(w��p�͞�&���1<H\$r\r��c&�`@\n���Z;i,�i`���E����H\"Mc�|��4#�<�Fi&0��F/�\$&hvD���|C�3G\n�4N#�1b])�c�#�=;�l���,��\n\"e,�F�aN\"8�XV�h�P�\$�BjM�X���U1Ft�#+pډ`���\r\$��o:���qS�,�	��7R��3����*)�h6�&��vM�D�T-� ��Xrj��c�F�d�KU|;��sP�X��X���&#�DGB2d�g�6L���p@�he��/�::&�E\"�ϱ�F�:s��J	�B�8m�~D�d^E�k�J�޽ �/'�.0��2M�o�;%c��mRŀ@�	\0t	��@�\n`";
			break;
		case"ru":
			$g = "�I4Qb�\r��h-Z(KA{���ᙘ@s4��\$h�X4m�E�FyAg�����\nQBKW2)R�A@�apz\0]NKWRi�Ay-]�!�&��	���p�CE#���yl��\n@N'R)��\0�	Nd*;AEJ�K����F���\$�V�&�'AA�0�@\nFC1��l7c+�&\"I�Iз��>Ĺ���K,q��ϴ�.��u�9�꠆��L���,&��NsD�M�����e!_��Z��G*�r�;i��9X��p�d����'ˌ6ky�}�V��\n�P����ػN�3\0\$�,�:)�f�(nB>�\$e�\n��mz������!0<=�����S<��lP�*�E�i�䦖�;�(P1�W�j�t�E��B��5��x�7(�9\r㒎\"#��1#���x�9�h苎���*�ㄺ9��Ⱥ�\nc�\n*J�\\�iT\$��S�[�����,��D;Hdn�*˒�R-e�:hBŪ��0�S<Y1i����f���8���E<��v�;�A�S�J\n�����sA<�xh����&�:±ÕlD�9��&��=H�X� �9�cd����7[���q\\(�:�p�4��s�V�51qcE���!�x�-�0�X�2򨑉��_!���h��K�#*����P#fB�/�8���rZ����(�f��B�6�#t�0LS\$�4MS`@0�c�w��>w0K2ܻ/��H�4\r��0�p�8NA`@j@�2���D4���9�Ax^;�p×�2�]*��}��Z��2��\r�����Ҩ�,�px�!��Ȳ<}���Z�:T�l@&.#	�xd���<!G5�YZDɡ���lMʿF�v��+�X�Y;�z4.`�0�Cvb3�(�էI��y�������Ľ����i~��Kʟ�!�ʇH#\$��)�e����E5V�r=;ԣ\$���YT{];��|�!4��8�)	�>)b��q���{�j�F���D���礵IR�3Ω�Y\">��#\$>���e4���o��!�-�ejȗ˪|���Å���Y�=ٟ���Q	��ݞt H�%1%-���S�%B�Mչ�]�jAd��\"m�Q���3����w:�Ҟ,�v}'���	ln��q�=s��I*ʂ�x��xLFEi�N��\$fL��t���h�X�!N��cQ��@� c� #*�ƕ���rH��`�%\\Hϙ�X&�	8���*\"7�-���C���,(�+%���1�Ug���3HHq*�X�\$d��Jd�<\$����I�!��0\\W�Q�J>�4O\$��DD���@����XN6����%MN�q;\n)\r��F�9�M�\\��3.}��?���&2�k�ɳA��álf�N:#9���(3�����(�ϞFƻs�G���@�4�b�R����#�C�	��Μ�\"rIHdx%H��(�W1��^�q@R�%P�1�e.��0I���h)-28��@hL��3 �Ճ�]ᑙ��@֚�^l\r��6f��Sl�ͼ97�W tp��Z�\\;�Tj��!��}�l|(*x�Ap��q^8mZ�/���i��!\"d\"�7mYw �Ԥ��(B��9LMWKt.�\r��\ru����[;imv�7����]��x���4܈�5=S�)jA��1����6�O��-e5 �9Dw(HdD�G�\n�/��(6�DD�,i�\\or��A�|��x\r	}�Z%�Hl\r��1%�����m�0�e�_Øug��3\\Vxgf8���@�����@�1���a\r�̺�Sʑ�:�C��[T4ILA1;6�'�5JX��mл�K��H(hX�!��\"�\0(.@���5�̃�h97��C�i[���ؙ�e\r�?\$�g�Hm[:\n�����}������J�����l�z��dj�73�A��F�\r���5ޜ[�(\r�1�f`�,K��1�K���6	�9�3�<��B����K\"&O�~JI�R�Z�\$1��|N�*e�L�J�#\"T�W#���0e���!����%D��!L��X �����6�n-P��#Wir�Qڤ���'�3.&fH�*?\0�T����Zj�Tdˢ���|�X�`�V�^J����r&,so�w��Z�r�r��r}	|���T��#�\"3a�)���։�r�}wnJ��dQ�t�(,qF)�r_I�H*�u�_��qQS���i<gl����R��;�W��>���t�у\"���4||�%�m�ȟ�l��O��/G��;c\"}�P=I�r�!�9�G��m'�WBF\"G�ј�a�.!9�H�\"�>}�P�Ir3��:Z9{�?v��K��,��d��9�إeCR����	�H���#�%�B�B�����@�4%�td��\$CϚ��F꜄�����~�\0(��d��K�(\\	\0���l�%��Z.IvX����8pE��Ǥ��\\#+�_M@e)�#����a��?i�v���ZZ�\0H�.ߨ���=��OČ���E�a�d����)G��ew����L��XuOTt�i\r����zP��H�'����0*t,6�K\\�BO	d�3�\"D�ʘ��Yg^Z/��b��l���*�L��U�/H&-.dh�Z�/F��n�w%7\"�퐠���*���1x#%(�	&�2�<�y�KJ�IA��)4�A\n��X�V,P1\0&2�-Fa\"Xԥf���\n�� �	���8����*2�FH��l\$�.�B��X�P�� �\"G��y�r��@z;!�q!�_g�%����v���Az���|�0	��0a�G���<r3º+�:��b�.'�\$��Q\"���O�^!�<��nF�\$r,^�j��ܨ�,h����&�B(�%H�*�*�:�j�=��+1ފ�0���F�ڭC�,\"I,ro'�VCҸ����)�(2��ހ���Ȇm@@�\"��%\"\\&%�\\/���(�e%�(�*\$(\"&\"Y �R��/!��'��FB?�\$�2��R��R���-耫g5�2��//�C�1�vd�Q��np)��{����O��zJ�`Qb!�'�3�w	��ChN�o�0o�0�w�R�k�F��;ðeDP��Ju�.�\$�N�^��\nX/=��UZ��Jc�/�.�3K?P�v��*�\0��)@g�@�{@�����i<�6��\\��G	1NU%Z�T��N~��,ڛ'�Ո\0t(���\"0�b�	)��[F�OB�d�O���a��b-V\$/x��=�w4\$��'�UN!IC��ST���\$4��/mG�p��*ro��3B#<S؜�b���	���d30r�9'����\0��NT\0�@����L��?�1#��<�F�H�@/�Q�?P3`�+d6�c<�CS�&TRB\0*�X���4,�EO#,��8'6\$�,��A�=u(��MM�Top=r/���Ua&�E>SQ	�V�-�uT�U/eXXU^c.3��kL��Yr�Y�|�6�B��:/,��R��*2a\\��\\� �*���S��#��-����_�	@�\"�K�Bb���NϒO��\$=%�Uu��x��&&�9`'�貫��S\"L���\$�yѹ*O�0i,��1aD+&���:��զ;\\�A]�3��N����\r�c?�5Q'\$�/��r�D3��MtO�SY��,OSk0�k�]YU!<e`��ko@�6�P�\\u'��m�c?p��ZY��n*Mv�\0�o��k��l2�p��8��T�/5)lH�&s`�ow	P(�Bwq�UB�>�a|{��(A\rt�BB�����i4R4Q���S�pUՈ���m4�<�uU��w�V�A��?��@w�`�'M�+As\"�S��QjS�����8v	H;Hc|V�AՃw�c��T	mih���tU@AWt83�%\0�!U�p6�SW%O��R�OO:u�8\0=������!\nS����(�8RԛQt�{oNtX����c����c����\0bo�2��#�9�8A�T�C��u��B�0#�~�*N��z�{w7}sÉ�E:H(��]���b��qJ!u�t�^8���-6nHۉW-g/�q\\!xfW�1���2�Bt�Co�5sVW�޵iA�^`�Y��98�l���wx[�����\0����mJP�{��+_L�:��+ssT�%��#��U��0a�Uw[�e%��*Y�\"�Q�vyn�s�<.��\$c�D�Q�H� +f�2m6ف:�gA6�\$9['��UN���*�VRs��{_XH���[��/�쫥4ir\r�VR������º��EeD�N������B�9�E�&R�+ag]e�^� ��LS@�\n����j�c��22�2�hˣ�M�UT/zBZ�\"&jD`zMf�;�y�x�&r2��p2E\rF��\$�6\\5��i�I	XL�d|�8v��V�;QT���0�|��L�nη��#\\�\n���N��A��D�-6�/1h��J�O��<�s�e�Z�?�U�X *aX�:���cj���}@����YQ��h~cL.��iџ��\r���T������ܲK�cc�������uI��A����3�����K��=C�Y�ȭ\r�݄�./0���Ct9IC�D^��@���+�Ee��V蔧�z��h>����GX�r&:�# �y��d�pӦy\"Z(���߶Đb)��r�j��d::������A�6t���5ԍ/��IY|\n�P��;�@�Ĥ�]��x3�l��8'Bg�À<Gx)�255\r�7�~���";
			break;
		case"sk":
			$g = "N0��FP�%���(��]��(a�@n2�\r�C	��l7��&�����������P�\r�h���l2������5��rxdB\$r:�\rFQ\0��B���18���-9���H�0��cA��n8��)���D�&sL�b\nb�M&}0�a1g�̤�k0��2pQZ@�_bԷ���0 �_0��ɾ�h��\r�Y�83�Nb���p�/ƃN��b�a��aWw�M\r�+o;I���Cv��\0��!����F\"<�lb�Xj�v&�g��0��<���zn5������9\"iH�0����{T���ףC�8@Ø�H�\0oڞ>��d��z�=\n�1�H�5�����*��j�+�P�2��`�2�����I��5�eKX<��b��6 P��+P�,�@�P�����)��`�2��h�:32�j�'�A�m�Nh��Cp�4���R- I��'\ncʳ\$��s���@P��HEl���P��\$��-��64�ba?����*NMM%4�-N���P�2\r���A0[Gp�'#~9��p��ה��)���:\r��B�D.9�`@\"� �3��:����x�w���r�Ar&3���_l���^)��ډ���̉�c�\0007�x�%\"��)9U�*Џ���<3`�5������Cs��\r	���V�#n�(�'9	�4ݍr�����R���5�N�� ���h:Z;!á�](�\n�`%�)�BP�\"�քLV9�(�+\\c�6A�p� bC�(�ë�1֢ϴ����%���CX����z�P�d\\22@P��+C��&%֜����Y>9�׾J���65���9�c܇\n\"e���������<�m�xɽYk�����Rc�J�vE�b]��T�^��/]�ۭ�p����1�J�H��b(��>~�~���e�U�!{~���C����7\"gJI)��3`خ�HO��P��&y!=a�<���V1�a���@]��M�t0�p�]A0h�ͱ�PP�I)	�e*Bt/Ma�' �!�0��p �GX��2��Ðmm��Fr`�T�UZ��CeT��;-��f��)\n������J�V���-�X��K�\"��.%ȹ�B�]��x/%t�W��\r���6�W�>����TaD���·��[+.��!�=b�a%\$�Q�E���	W��!���[D\\�u���׊����9/���	��\09���	�j���9&��F� =a���3����Yj/�Rt���\"��<�BjM��I�A��,Y��hQx�E��Cf6DR,xG	a<0ZKP�OB*��\0c��x���de�}3�6�ɒ\0NEȑ^9�_9��2�1�ȄNC�b��Q��GEm<`��r��#��,��iM8e5-��j�#�\r��èx�)D�@�ž� G�k?�Ց`��1?�Q��������\0�;�Jj�C:�t4�;��HB&����<b�%������aЙȞ���s�B���v/JaZ��q)	\$,<��yj�'-jT��[�Y�\0!��!���d��ڞ�\rJw<��0�PP	�L*1aB_��%<1:��N�U�Vr>��~RQPf.a�����;hd	�(����@7�Ř�� \nn�ّ�b��F\n�@���K�d1A��4ڥZ�HC��=R0�Oȅ�-DL�c�H\0PO	��*�\0�B�E�8�\"P�qK3-� �5&��q��ƈP��bJ��ӡJ�YƋ�ؤ��;�x�#Ȇ�Sz\"j����I�Ax�ݙD�4c!�g-���g�P�|-����\n�c|��������S�/��f|�zT(aC�7�wK�'2Ij&\$Ɵ�*E�p:NH�\0��7��~��쐩%�8%Ii�����Rh�>Wd�B��f����*놪8�TDK�s�l&�0Ux|�Hc�=r��+��)<E��I�\n����0o�t��v!�.�,<m�ȀU@E���n?��Xc�a��q}�DkX#��ԇ\$������{�IM�dס�owF6���^�3K#B�VD�����)+1w��:���[f��l�Aa [\r���U�X!��UZ��٤��[�v���G3(\$5��1FL'F�e�!���\$aZ��2��V�u�8��&��R��'�;���c�걜2��ֳw\\�i+���a{#���v����y7\$=��S^��t�%%挙w�ك�&h�j��`{Q�P4� 4t�;���S�ҏ<�O���^���@�SZ�=�(��S��@܆�I�)Sd~�1�CH>	GƟ ��blN':�\$(�2�Qӗ���H�!���I��e�#E\"�11S��Qqt¥4���}pHF�Y��\$8�nr�\$��9`�<\$�(-�g	�&�#� b�CO�L�J�F+C���cpxFrO�;#v�!B�Md�p.\"�6�-��P�B��0�<�-g�~P`�'.���(�\"~H���hZ�(�p�W��\0b �� G�����L�G(��I���h�#p�\r�d	�A��l�ȃ����J�!R�D��M�f@��ƪjx�A`S�J@g�yPt��\\��{�� pV��K�`�1�FDy�1\r�mg�Q���P<\nm��1A�{�/�N=#�Cn*�E���d.��q>����N�At\$�=��.т�q>�����ћ����p���`���``��-�ެ0C������������q�ށZE1��|����\rFjIB,��!ljj`�)�/i�b�X&d��bf��i@�[�fh2�<W2\"����ҧi�(��IR�-�*�#guD�K�\"�*\"�l+*b\$�����E0f�Bu�dg-��L�b��\"F�ڭ�i��jg��H�R\r*�U+��r\n��#,ǯ-�,c��B�(�/+�_�2;��9qc+Qg.�y.P �	.Þ8'/�2g���0��x��\08f�P\$\\j��\$�}P�ڪJEK'Q� c��&�q����2��Qq=/��3a�W,�@�����\r&e7O�6���L�(�xt�|���v��g�\$���d�\rbzEr-5q�qf\nd_:�Q�o0q[;�s<2��\\ G�U3�;�1��@�<�k0� r�Ҷk� sƧQ�ڮ�8A9G�:m�.m�+�Y.��U�Wr�ߔ(�1Y@s�~�?�@�>R\$�K��/-��*R�Aӷ,%'ENGE�}r�@tcEnKF�-TPbF\$�C'N)qvگ�r��I1�D��@��h�X�T�f>P3B��@��D5Ԣ�_K�*oh	b@�#h�~\r��Q��J'+J�*2\$_�B9	�'�L�\"M��`ց��&��Z8[�@\"m�:D~Dt(� �ɴ���*�Ā��Z�Eb6<�0u�Xq%���\0�J��U\$%'Q���J�CVF��\r�\\��p~�**�\\#�>����&	�JĜ\n�n�FI�_\0����J)#dh�C	�Ԍ�d��p���<�,	��h&m�J��/��j,�)�4JdJ��Ӥ�U�膱0g<D��b�;�c1��\r���P.�Ќn�s'VS�Pz�\"p5c@'���`�W-nC5�)�X�үY��*�+'��I��?Ө\nˏ/+�ѣg�j�ȪPW#T5�t��X���|vKp~q\0�&p�jc\ndTM�9#|u�1��`��Z��l��K�]�8�,�l�2�(Շ9��<6S�<\n�v`�Ƨen�K�	\0�@�	�t\n`�";
			break;
		case"sl":
			$g = "S:D��ib#L&�H�%���(�6�����l7�WƓ��@d0�\r�Y�]0���XI�� ��\r&�y��'��̲��%9���J�nn��S鉆^ #!��j6� �!��n7��F�9�<l�I����/*�L��QZ�v���c���c��M�Q��3���g#N\0�e3�Nb	P��p�@s��Nn�b���f��.������Pl5MB�z67Q�����fn�_�T9�n3��'�Q�������(�p�]/�Sq��w�NG(�.St0��FC~k#?9��)���9���ȗ�`�4��c<��Mʨ��2\$�R����%Jp@�*��^�;��1!��ֹ\r#��b�,0�J`�:�����B�0�H`&���#��x�2���!�*���L�4A�+R��< #t7�MS��\r�{J��h�_!�\\L��LT�A(\$iz�F�(қ0��*5�R<��l|h ��J�.�����?H�~0�c5��8@��/��� ���h�\0�C\$&�`�3��:����x�a�͵\$������{�9�^)�2���246�#L��|��k�(��âZ\nx�0�I0�3�� Ĵ�h �%�O\0�ˌ�%�~.K�촉�|3}R2`+�eB����Ę��N*b�R�b��Ӑc���%C`�2�`P��B\\��c�����-�<	�2��Z����6'��:�W+Ծë�1�sд2C��:N��\rj0�'N%44�+#l����&A	\$h\"\r�e�E�����hz��63��(1�n��ފb����89��v���6.=_*�\r��*��\r��s�';nd������;\r�+��D�\0��`�����bM}ƃK���ZFl�1��3�Ҡ���%�>Yp��[�p��LC�;O��8@�-�&�c\"�6��\$:�!@��z�BA�����b���p ]�\\�B���mh�\0r��Y���(BnC�+:�x��CyL�3ʁQ)��PcL����hcH*�WJ�_,��1nY)f�^}�%L�LD��W�L�آ�#�KaV�H�x@v-\nF=2K�i� )ug�b��qz�0�[C%v�U��Xa�b�t�HrYk42�����`�\$���e��t� �/\$��С�[��3��Y�Bh0�s�Q��&ሒd��;m�f��F��U-��D��Z!�1�G�����p��*�h�s),2��Id�!Sz}\r\n\"�I��5��O�i\rVl��;\0�@P\0���:I�[�7���4�T%��J0��ʅ�t3f���6�ü�~��B&�Is.s�b�I����<�8���*堬�w4��q��ή�p�b���bτl�:��4�+<�1�g��)@���\"A��)�ث�Q4!Ly-�B&LY'\r(QK�`�\$M!� �Ŧ�@�a���d��H<������G�N���B�=p�T�!i솣��3h՞.�1A�3=�V\0ڜ�e9��\ny4���@m�-��ĄʿMH�&�*N��E6d��\$���xe���pZ�\n:���'���5\r�:�E�uR����d������?ƶG�j�[�4	��8�Ku�A�#���0�H�a<ĚT�d\n�/Z.D�[�l�PP�L�%]L%By�I��r���\n@r��&y�d�|�d����\n�Y\0����ȘR�^_U�l!ro]gD�)�\n��zr	�t�8�'�2f�@PZ��š�Fe�#�OS�C?�˳, ,-��H�1�-�-��JZy�HP�P�%C\0/���#@�U�a�sFȷ3���]�A���&�ܭ�&&p�lnHK����8���xH��a�8��.B٣�-����\0A5�9s.`(#-�S�	�o��ʐɩl�<x%s���TxT\n�!��AWy�yT��\nB���]��t<\"f����a��C�&�\$�Sh�]�v����x�( �1onH�����\$�Plݬaʰ	]��o*}�C,O�c�}���TCYsw�@]��~�����n����;�5ӛ����%�#�m��7ѳߓ�n��y��M�Hâ2L\\=t&��z�A�8�~L��(��¸;��Qo�*rx��&c|��쎃��!����%N��ziu���p�u�:�����rt���I?=�܊��@�J(l ���{�Jk�I��J�~Z	y����8��SJO��\\:9��1;1��&�\"Lh{�.j�]�_j��(����յ3\nG����`Kڛo����T�D�\rչ���~OP�R���G�T���e��v,\0�V�y��re������Paۤ�tH��%�T&LXe]Q�0���hc��]��=3�t�3��Đ����B����\n��-\\���@�(�N*r�:E��\$h �e`Ɲc�n�F#�R&����	@��D��\nO(�!o�E\0�mX��]����5g��PH�Xw�P��Pnt����B'Kr	btp���	Hp��&V\rn(�ݮ���	��	�\n+�%P�\n�l�\"��n\n\r.М�P�\np�(p���0���7\r�+\n\nkmE��A�r�NT�͞�����p�t��Cw����kgko��tJr�`H\"L6��7d�&Te�B<#f��F0��]F6BJ	�.bl\$�V5�\"9�j����1P��6�AE�����n=DI����,�a�q�&�Ċ,�`��7q�e��_��а�Q�B�Gy�pa1>�Ѓq�Ԥ&(q�1�)o�����0n�M�:��5L���(q�w+ ��ɦ~%�b�Z�N�	;�\rc\r�\"HE�\n����!mAn����Y\$�]q=%�(��L|&�Pg2±�%�v�%'��j���R%QNP.y�`�\0�&`�p�����R�*�1!0���A�1/+��+Ҕ�E\r*��-&^���Y.rm!Q1'&3�a(���^-'n��귲��SN2�=�0�����3\$s(mXz�2Ѓ��G�\rr�D��'1.P/Q2��\$�5��%�?�Xɢx/cb-2i)���B�z �uD�#.����ؘ��X\"���s�3P�:N�S��#5\r�fS��0��\$�_	�ȷ��\nrD?�vb��Gs��9�jI�2�P�ӧ>�z�3��������\r<f�����\r�V���0\n����~��^�@�/��#h\n���Z�*�&:�v�>�3��E��z��E�;��FD����b��*�s��\"�0#E��C�q�OK�/`� \nB�S�mIC	�<dN��|gN�L%P�-���+CB�%��\r�0Z��=��M��T&P6,r6ÂF��.�.,�2����4K��Pd��NP�5��x�- �'t��wGu,2�61� .��JM'T@o�P�h_��k�Bg�b(��p,�\r����\0\"x�����AV��B��9�����MB+�@�S��G\0	�Dn#�m �-�=Oh�/@�CZ0��\"b����&6D2k\0�'S7�ҽr3R�� ��( ,.�OB�ѵ��8Gc�K�";
			break;
		case"sr":
			$g = "�J4��4P-Ak	@��6�\r��h/`��P�\\33`���h���E����C��\\f�LJⰦ��e_���D�eh��RƂ���hQ�	��jQ����*�1a1�CV�9��%9��P	u6cc�U�P��/�A�B�P�b2��a��s\$_��T���I0�.\"u�Z�H��-�0ՃAcYXZ�5�V\$Q�4�Y�iq���c9m:��M�Q��v2�\r����i;M�S9�� :q�!���:\r<��˵ɫ�x�b���x�>D�q�M��|];ٴRT�R�Ҕ=�q0�!/kV֠�N�)\nS�)��H�3��<��Ӛ�ƨ2E�H�2	��׊�p���p@2�C��9(B#��#��2\r�s�7���8Fr��c�f2-d⚓�E��D��N��+1�������\"��&,�n� kBր����4 �;XM���`�&	�p��I�u2Q�ȧ�sֲ>�k%;+\ry�H�S�I6!�,��,R�ն�ƌ#Lq�NSF�l�\$��d�@�0��\0P���X@��^7V�\rq]W(��Ø�7ثZ�+-���7���X�NH�*Ъ��_>\rR�)Jt@�.-�:�*�d�2�	!?W�35PhLS��N���T# �	Fy8r�!ȡ\0�1�nu�	�Xn1G.�4�-܂0��D�9�`@c�@�2���D4���9�Ax^;�p�`�f3��(��㜓%���\r���	ј��X�px�!�D�3���L]Kjh�{#4T�M\0����\\��QR���Y�r����{38�'�q��6�]}ܢ��9\rАΑ��\"ϼ�`���,�����\"��ֺN�*�\$�E��Z32�Ɓ ���j{W�\n��=&P0��d�;#`�2º�����#ʍO�2n�?�����*������+زu���(&����?o;���Y0���M�C>W�J<�==�M����	�����?���(gbJI�T[����\\�ًkH,0��O4�u����V�\n'���rp�ɓqr����T�������6d<j��|f��t����o¢ ��4c�]M�.� �3�����S��1/`�A��D\$r\rb&��@DD�\")��d�C�C\0)�#rn�S'W!�3�\0Z��[Vt*���py�b�VÃ3��7�t\$�tR(0�p��r��7S�\n�)-e��uN��HC\naH#A���#b.�ո����yR!\"�R�\r�>5�l���m�T7Ȩ���\"�xg�R#D�B����N�Y[-e�ř�Vo7Y�rg����x�E�٨!6��K[���#\0\\f>�q`ȝz�^*5,PX�caB	����v���/�4�t���,�eL��3d��6g��v�Y��X�d4V�Chp9a��I���Ϩ�e�@��[KH��DTT���YtU�<�e�L[��m�m�EЂ�3�!�D4>@ b�6\0�pC�0����GR�hRF��I,����:���&���އ2�f�L��.4=��Bb]K�n��C�����(��f���.)��Cj�ށ��!��h�������\\rDA�睴~��o�\"U�)\\�I��1�^��`��{i��\\vZXn���&>ヹ�a������+�ر���#��.�s�*�d����A�� ƹǩ��byR%P��kW/��\n�'�d��Jİsd�5\0��HC�x���0RDϪi�9�8���C22\r�n��Ћ��GV.�\$s��*rJ\n\"��-,g&xm'\"Z�W�T�d�e8L����T�b2�,���P���C%WW��\"S�v�ڈ�r�%�������f�D1_`A��f������-xa\r�84��9\r��#��K׷Ja?��vV�j/�4�%	��O	��*�\0�B�E\0���,<��R_'�*��T,H\n�@�\"P�uλׯp�@�.,Uyzdd���Ŗl(ٰEϞaq_{\n�{)7�eԁ10\0���la����X(��V�%�*���4R��4�M�k��cJ��yL��Y����8is�S����!b\rn�\r��6��j�ŭ*��ż9�yآ¾=�8�0��̓�&��&*���u�9T��|����B����&)+\0uRh��&n��_�8�p޵%��%�}ȉt.%7���H'�2~چ.e����_,|0)����-�A��\0)�S�p.DUB�\r��ۂm���s'V*4u����������u\\���	�F�C�ѼB�)�_�LB�H@ALM��(A�;{��!��JS�z����bV��/�<�%�!�q'37%.�*O9�P��4�2������\r�R�,�ط���~�\\@��@ ƾe8s����:�}�����&�#��A�d�'1kC�jp'�50��'i�)	�)�JS*�*�Dr���.���*�\\(����c���+'���pZ-��¬5P8&��l�H�T0tmn�}��6�X�0]���b��0�����j(PT�,�	�-0q\n\$�Х1\r����\r�o	�Ip�\np�\rb�ˊ'P�	�F[�h��Q�	�*�d�F\$���h>���܅�)��A�s��%�+��-��<.D��v%&-�BNp�d�&Ab�Z�ll/�T��1ry�H�Q\r�؋���m�{ǭ�C��\",�#�Q�\0��l�O�M��P�C�,t��&��f�(�f�q\0��L�cp���J?�,�1�.1w���Q��'��г����^�J�q.���M!2'!�耂d������!n[�X�G�:Z1�L�RP<��N,�.��VDd\n�#�^߄����(N'#V�2(l%&��'!��r��.Ѕ��?�LOoHQe�B��g<��׋L=��>M�(Θ3\r�]/������H92Ԍ�r�R�&���RfT2h*н-n@�j	�<�G�0:���3\n&�/*Ѝ/�r1��r#2�*�F�\$�-s91�,1�12k�I�p-�5R�3��\"�>P�q�np��~���	��6M�6�Z�R�7a�M��s{�~�hV�8p53�� </�~���,�.���#3�UǱ�J���%=<�1-H�s�3愺�h@1H l��*���R�.���R�3�>1��\"QbdL�C3���\0I�@gbr�+r�'�@_1�h_؂b*�-gҴ�ڬ/�!���?�U=��>3�=ol�DotH^q�*�n�D�oӖn��L1�2#Y w(t��3�3.SI�J#i>�KC����(Q��I4�{0^<��<t������kIsM2S�-�L%�KS?1)����T�L�N��������=^P���F�C�L�c��0~�ʬ���O��G�4�KJ�B\$��8;=sO\"5G:�#��>���Rl�x��އ֌(gON�-Έ�F��O�>��5f=��A�qX���Wn��#�Hɂ�(oB\$貎��t�����X4�[T��J�`�o\"�K�5��tb{[q�>�E6aN�?Oto%Z�n5��~�_�H	���^�!J�\"O�\\ԛ�aV#U��<��8c�)�,@H���XT�c�!d�)f�S��L��Z��^ua�5J�If-�bS�JĩgC_ScBH�E>�TU8>T�7���ϊQ�VQ�\$׵����{m�<�+j�����\rk3�r���y��l\$�T\$�d�Q��mРq�mP\$pe�/(��S�#0cG�+^L�q:�p1p1�l��p�M ��@�ng4=ub�B�R¯I�Nb��\r������h\n���pWi��d'\rS�JV��&�¶�vkCk�J�V��<֮ؗ�����K�J�EJJTF�\0	���`�/�%�4C�<��f�P�zC���²�p,�)�+r���&0nwq�}�[F��1	wI({On,e�T�dn���Av���3�mgjׁL'P�רܙb�4�ӂT{��R�0��g\"X��.5���7��'���u�f��XG!X:@����8��R��wTx4\$��%2VxR\\~���賭݉�J���+�8�c>���1�	TUc@\n���\r��:eT����n���ʘ1i5�����)�&'�8/}d\n%�b\"t\n��-����D�4���`����8�[8g��@%B��w9men�.`";
			break;
		case"sv":
			$g = "�B�C����R̧!�(J.����!�� 3�԰#I��eL�A�Dd0�����i6M��Q!��3�Β����:�3�y�bkB BS�\nhF�L���q�A������d3\rF�q��t7�ATSI�:a6�&�<��b2�&')�H�d���7#q��u�]D).hD��1ˤ��r4��6�\\�o0�\"򳄢?��ԍ���z�M\ng�g��f�u�Rh�<#���m���w\r�7B'[m�0�\n*JL[�N^4kM�hA��\n'���s5����Nu)��ɝ�H'�o���2&���60#rB�\"�0�ʚ~R<���9(A���02^7*�Z�0�nH�9<����<��P9�����Bp�6������m�v֍/8���C�b�����*ҋ3J���`@��h4����,�J�줞�H@�3� P�4����<�C*�)�r4OEL��6��2n����1>S3�#�P����d���e7#�;�2\r��;0'�+N���B����:�q��)��3�T�K=�O�\\�H����D44C���x�a��*71�(��A{h9�c���J`|&�*�D��x��}\0�`ԁ�\0P�4(q�5�����<�@�<�W���5Ҥb<���+Nԋ&�\$��!.����%����Eؚ���8�R--Ф4�\"H.�A��H���W(�è�x\r6�` �n*�n�\"�n�&��6HB�|�f�>V2�B�3�ʮQI\n�(�:A��a���2Re���S߫��5���(��h׍�c}�K%����\$%��T\$�0#P9�ssm�6�7D��s��\rU�3I�8�#h᥹(��Ś`��.�z���\" ����SsZC��);#r3�%��	�SRf��@6�L��4TC�Ƕ>��1��X�Ò[)+r6��%�R�H��y/�J�g��\$m�^����~��-?��!�=���@R����f8iy�� ���Q*��ǐSY\0	S\\xH\0���\r� ��T��~���G�K���5\rΩ�h��ºW��_,��42�)f�^�\"[�PE�c�6LD9��d����W���\"@��\$P�C!�O��\rF^-�!Vj�+pʮUڽW�a�u�b�KK-f��>Ub��Z�t88i�Y�mT<r,�#�{'����� �/��(�#Ho�A��xξ��\r\r�Y�Ѱ6\"�}�3sF���*IDc�fSeI�A2H�����Đ9�hJf�gj����\0��d\"�a1))�JPa�@\$O�)���[B�\n\n`)w\$	L62�\r�	4<J�R5uL�3&l4�'��	�5�惔,M|'��4M��f�|\"�i\r��,EѩzT\$�3�x�ϸtz�d�v؁���D�25t�M���a��ঐ���\"}��l��Y��*�!lj���B��B�(����3\"AJ]P�f@��c��)A7 d��0#鬋���\0� -UH�LrZ� 	�u�ʂ.�H��h9� �qY�F�v���LH�,���7\0ZK�A�%!*ts\\�ĺ�K 䜑Fd�]�7�I��s�M\0���B  \n�@(@�(R	!8#�{��xR\n�P �p�t�b�rk'��yhJZ:�X�#\0��O9s����{�)�gH��G�h�p��-R�xJ�,�d��\$�~!hV;��o�A�\\�-s��\$�����\\�E�t�Q�\r%ܽ���Ē�P���N?��;'t���H�H�1iƘ�&rRZX�Ö�a���T���(�D����ޘ l<�g�3�ir�(��CqK�h���|e��s>�ᾷ�9�ؚ�\$�(&��⾎E��*b��x�Cs�/'�;\"7�dچ���h�&qT2���]��\0��n�lЀ���!�\n��9�gBt<�@�ݰ��E�3���r�aϱV?%<����Y�C\0�l�i\$����yY���>�����%�r~A�k���fsۻHƐ-�n1\$�a(�̷�%q3�el}{�7���������s��ʍP��]��6F%V��3B`i,�=~�5WV��-�ɶ���j�	 \\W(��,��iq]|9@�bMSE��z��M^x�L!�Z�MR��C*�&��F�̛�o���0\$��i�ꐕ�Gޣ��N��8*x�Lg[�#�:��]ҢwO!�7؆U��{.��%��=��,�xY�rZ��>!o3���Z��Iv���Z��H���� )F7�W8#U��Oa�xkҟ/O��b�\$_�u%�hp�����o\$o���Q��y7c��o��^��9U�:��6_��_���v���6ˇ��Ͻ\"�qo˩��ܳ�u��;�×�\"�C�\r��/H�Yw��?���폄�ζ����\r\0B�.�	l��^x�����6��>����4\$\\z�N��\$�P\$�ظO8�l�Gep!l�UPJ��J>B��p��ό�m,�o�nOLv�PPb�����p��OT��`����^�TՂ/	O�E�h�e��P�#Ϡ��y�P��9'PJp��\neFHF@�j~/W�RG�\r\",�O���.��;Φ�Q�P�M\0��lg�LJ ��\r`�&�\rMa�.^E�l\$�A)�E�N\0�Ղ�WNKn{p����D:����>qp����XcZ����Q^頨E�h�Q�xc0�l-M8�P�э,m��On�q�-!��+M.j�J��\0�G��Qc��DV\$�D3B.�,L�PA1����/l��R�1��l�uH	�2C�c���	�n0m�2�JZ����M�\0Ƌ�:��LU�Q��-v��ъ����ϑ\"2\0��@R��[\"=�?( �&��D`�`�@�&�d�8N�\$�φ5/�*\"@�#P\r+�\n�NԎ���Ď�Ҷ'J��݈t�ޢ�r~%:��du\$�O1�L�`8��9\nED=1%\"TCʁ�c+O�/���\"�	< EU3\$V9\$z0h�'Bj/\"R8��i�HN�(�'�A��E��*J��w���Z�.�n`ࡲ��!���s�6| @ތr�/-�7�\"^�hp:��xF\0���>�\$\"�LÌ��:\nM�I�H%�9�k1B�}�&0k��b�:��f�����JЄ��RO�?�vcS�t��s\n��U��v\$Lc]d@�z<�\r@";
			break;
		case"ta":
			$g = "�W* �i��F�\\Hd_�����+�BQp�� 9���t\\U�����@�W��(<�\\��@1	|�@(:�\r��	�S.WA��ht�]�R&����\\�����I`�D�J�\$��:��TϠX��`�*���rj1k�,�Յz@%9���5|�Ud�ߠj䦸��C��f4����~�L��g�����p:E5�e&���@.�����qu����W[��\"�+@�m��\0��,-��һ[�׋&��a;D�x��r4��&�)��s<�!���:\r?����8\nRl�������[zR.�<���\n��8N\"��0���AN�*�Åq`��	�&�B��%0dB���Bʳ�(B�ֶnK��*���9Q�āB��4��:�����Nr\$��Ţ��)2��0�\n*��[�;��\0�9Cx����0�o�7���:\$\n�5O��9��P��EȊ����R����Zĩ�\0�Bnz��A����J<>�p�4��r��K)T��B�|%(D��FF��\r,t�]T�jr�����D���:=KW-D4:\0��ȩ]_�4�b��-�,�W�B�G \r�z��6�O&�r̤ʲp���Պ�I��G��=��:2��F6Jr�Z�{<���CM,�s|�8�7��-��B#��=���5L�v8�S�<2�-ERTN6��iJ��͂\n��\nq?bb��9��m���Ţ�L��\r�\ns;�9hyz�Z��I���+�&aX�JRR�Bٳ����ۙ��Et��It��&E���[j��ndF��ĩ@ ��l�3����O��>�1�����p�8<C��������O��2�\0yӍ��3��:����x�߅�/7L�t�3��P_?t�L\0|6�O�3MCk��x�P�F׷0�S`T�n���z��1\"�pP�R���U�q~�}^�TC�}��.�RN��|�!i@bt���~0I����R��@�4�/��WS\rA��J#�p���W\n�9��%��}���,`&���ᛁ������u:!BB!���p��9�+�>�6��r'��0�P؞�a\r��2�󄽟J�)J5�`��te�����DW2�B`� �p��;�T�3ô��sH\\m��j��g��fGe�u��Gi0	5�dIZ�e\\�(I�	I�N,���S�\"ލ��6FHa\r�(�'��:[��3�#%r��DB\"��xG�(�I�B� ��5��\\�ح��]�2Mt�6��Q��VJ�N�T���\\��gĢ%�y\\�6tC��)gq]��`.d\r,d���������<ݔ�a���\$�6�3�(\"Y���I�O�*MxG�J�0M��4C�i՝��x��=�T7��i7���Js�uM�1CX7�&�0	���rGl�����0f\r�,��~�<\n����AorN]̆h�\ngI�ֱw+ R@ �0��S�\n�)+�)� �R\r���s�u+�4Z((@��d���HsV�ʷ�!��7Y�b(�gWjt��`Gy���E^Ze�.Q�i#\n���\$�C��O��U��p@�gu��R�0��y�vN��;�t���xN-5�w��zsdQ�R�\0}x��I{�}\0��n�R�ZVIi0�#Jm�U��ؖ�Yf�����X��'\r��j���}��yέ3��]��u���Wn�]۽w��ป���yL�P�;��C�>�%�2��z��U�C3��kz��3�lm{e}�D64�	���RpdFŗ�\\�i|&�~`�lo������K@@�pL�	��0���y��6�KZ�^]�>!��0��A\0c�8�4� �j\$��R\0�2��n�r�-�SɆoLx A@\$��\$��WL2�u3W1?0T�郲��x����y�I�=�������NΚZ��E���T��Բ�!�J�r�Zc�~`vU��:p柜�zL�����_�C�uP�;���1�i��3����b�q8�G��?kNVCL\"O��k�lh5[Q\$3'f��2#.�]&��0�tn�K��\n(���f���Ȇ�`\\uLm;U����<���I#���8��܁ eX��dc#@�4�ۏ��%�܉�1�4��~=�p��6�<͊��\0�¢��a��E4fm�7��pO쫨��6�6G\0r���l�>~������6���A&PɆ.�<:W�ڮo۪�=�)���2���N^��tS��SOK�fi��I�1N��}�&1V��3�B��BM��l��xNT(@�(\n� �\"P�~�u���>�u/�4�\$�F���kZ��E�Y�زgҿ�)ԥ�*Rm__1�-�Fh�JL��4�d0E�FC���gБnl�f+�`ա)P�pQ�P���nBk��`���I�V�i���������^c\\�J�و��|*r�ɞ�0X�P���J�\$^��<fI@�lʐf��0C��\n������Q	dx�p�P�e,�PL����mP����O\0� ��޲N��b\0���\n?��hb�dBnbS\"��&�?���#c�Y����/�t�C�M ��`@Ӎ<ѦVT�<8䶾�W�/�\0��t9�Fb~\nGfv@�\r��cx&ό\"+�K���\r �b4�����=��׏�0��F�q�\$t�j����X	�*��\0�\r�«hf\nm�4�°L>��Ъ�hf=@��K�4,���\\��1�}j�0�+���\0�����\r���؛Ĩa��2 ���JO*�r�Ox��ԋ:��),������~�b\$�G+���BZ���&���`�RP���3ʝѣdr+�,k���~ǲ>ƆR�,��T�dm'0� �}f��������j����e®���8Ϟ\n��`����͆O ����Pr�Sp�A��Q�^2Z%/�9�6�j1�c2>��f텪���,0�F������.~�	p�\".:f�\"�u�q2�KIƿO-n�䲀\\37�]40���6�P�K�Ђ�@3Y2���Ȏ�\r��.�	���fF�\"�8s�p�\"��w<I��}s��+���+�[-�,��3�a83D��HAn?3�6䄲�)&s9>�{134	�;�8��A�?S��Ӹ�q�B��	�`t`@M �V��G�+�m!���(�DqJC\n:TN�+v�bE��#FGJZʐ�4Љ?�GH򕌗Bp�\$S� �|�JnE(I^F��J����RB0�HCP̳��[4-��_Dp\"����A�%��#j/MB�p0��3��p\\QoLNjڈM3z��6PNCf�=�Xhm�_s�G��=��8jo����%�n�PS�6ӑ5K*K�4�҇3�S�\0��UL�;�8\ngTsP��Ҳn�EA���\r��uh�\n^�I\$s�B�g@�T#�/6(8^�:ՉY�yZ�7��ST�>I�H5q[5K7�@���4+� <.����xW�/FN1R�P�`̋����F&�Fdbc\$�<#R�,��RlN�_M!:/�Fv'#̘W5�'W(�t���[a9�3b��Q��N�9S��]#d�/&�8���ere\0@\n���P�Ϲ2C�'�A-*|����c��%��	��\"4�*�8��eft	.�%pwiu�4�e��f3�\\�f��f�-j0Z�5o\\U�6��mU�,V�?I��Ӧ���B�k���ʋ�i6�jV�56؟��LJ���-�kq��q��p�#qD�w,�2pV�Y��Y�\"p\"�*��kdncO5pw^n4��1���26O6	�6v��5JV�X3ur�%)Wv6��7V�U�XH�ws;\"w�3���q\0��<�H�c{wT�MR��;{�=n�HV�Y��s��f�>VQD�Z�O[�mw�#V�2=h��C3~5ˀ6��eL�:WD��Xh�k0��d�}�!%�]�1RĂ�v�~V�ο\n�	7�Q\0�L�Tsf���ҩ�&1P	�A��8��?�Xt���&O�.���0����%�TT�8!\$w󉔋{vp����YXӺ�ϺfmL������g�\n\0�ҭ%yȟ���������x��u}r9@��]7�]iP1�%S\$����X,�x0���}x�u~���AHF�]p(z���WTHY/ׇq����V�۔7M�ews�zw9p�>���C\$�-u7��򴙲���i`�< ��+Y7k�	[NC������f�����{�o�9�T��B#��llҶ�t�pu���+p87��Qj�4�Q�yÚ�U�Ɂ��ض��Y��Y]����'\"� v�b���B�%&�p�n8�x֢�\r';�꒥�|���5=�ZJ�oy��K���]�7`�94B�Ov٥r�v7��sn�=��S[h܎Ǟ�Ifj)�ati�t�#���i�_������9q\\9ɪ�ea�\n�z�iEbo�tWO��!�y~����Ǫu�=[x�t{��_mS������ɯ����#��na�*i�Y\rgG�ShW�T6�HyOTʻL��`˟�s�z�U�Zƞ���Y���iʹ藱zq�[\"�MO���ط��Ӕ�Km��&S}�wx(;�׫�䅸X�W�)�c����[��	\r�����Z�����;������z\n�E앹ӗ��*U�rF�W*�;K[y�{}�ŤZ�\\Uz/���j��ө����4Y��(�iS/���/~{�+��N��CSY��#R(�`s��p�@2����>8�3z+��V��X���Q�w���ke7��8\r�J���3M��%����'�T�?�\$-RkB�O�SwI�S���Js�nwS���2_~��7��՛���Wc�w�wkY\0�n�\r �\r`AOh���v\r���tb��N\r�O��O�\n���pd+���>�����\n7-�嫶V�9�łRa��X\\�I��v]A��+�hCԲ�W��)�U������Y��P���\nk��RA��S�E���;�	�\r=Ua��e���\r��BĢ+�m|��ĉ�N;�f u��H7'����U��U��V'�T7E�\n�c�?��(�_�t�L��jW���ձ&��8�ZWv�4|a)�G��.���ys��'名�s/��|W�)�Abc�9��Y>U�iW��f�+���;]����?��;�I�-�U�\n�F>�<-�e\\�5;����o������{�[��m�.:����o�=���(�\0��U �I'��-\\�v�[�X��(�M�@�d����P�`�����7S�)\"�~	��qQwhf�\\J�C@S�a�)���X�>	+��QB��O���~\n���Q�hr�\"7�0�ǌ\nv|��AE��\$8�S�#�^�T�����v@�i��=��H�ݖ�h��X������n�J-�Y����U���D��	\0t	��@�\n`";
			break;
		case"th":
			$g = "�\\! �M��@�0tD\0�� \nX:&\0��*�\n8�\0�	E�30�/\0ZB�(^\0�A�K�2\0���&��b�8�KG�n����	I�?J\\�)��b�.��)�\\�S��\"��s\0C�WJ��_6\\+eV�6r�Jé5k���]�8��@%9��9��4��fv2� #!��j6�5��:�i\\�(�zʳy�W e�j�\0MLrS��{q\0�ק�|\\Iq	�n�[�R�|��馛��7;Z��4	=j����.����Y7�D�	�� 7����i6L�S�������0��x�4\r/��0�O�ڶ�p��\0@�-�p�BP�,�JQpXD1���jCb�2�α;�󤅗\$3��\$\r�6��мJ���+��.�6��Q󄟨1���`P���#pά����P.�JV�!��\0�0@P�7\ro��7(�9\r㒰\"@�`�9�� ��>x�p�8���9����i�؃+��¿�)ä�6MJԟ�1lY\$�O*U�@���,�����8n�x\\5�T(�6/\n5��8����BN�H\\I1rl�H��Ô�Y;r�|��ՌIM�&��3I �h��_�Q�B1��,�nm1,��;�,�d��E�;��&i�d��(UZ�b����!N��P����|N3h݌��F89cc(��Ø�7�0{�R�I�F���\$!-_H�[�����+�q���\r���sЅf�L�X\\5��_��6�bw��v���;���M� �ֈg���n��l+�ɛ�N�*��� ��l�7������A�S��1�o�U+:�S��;�0;��>t=9�`@rC@�2���D4���9�Ax^;��pþ���3��(��ÝE�\r���*�ӈ�ecpx�!�}������W��;u��2*�\n��Y�h���̳c1�M���!qLS�?�~�2v�s�8,�ӣ����9�Y'n.Ap�ΰ\n\n�9�Ù!���!�\\�!�K(p��A�K���f\$�sѹka������jN6ϕ�,�����'hp��F,�u\r��;�C+K&!���O	�X�	\\��T�'�`P��lJ�_+|�\"c�F�����쬇�\r�Blȴ������ʥ+&>�9\n��.��d��0V�IqB+T�������]S�vIP��a�d\n\0001���Qj���0�ڲ*�ex��*���.����WK\nLoue=�_/��v��,�yH+�+*���3�aJA�h<�S\$D�.oqY�ɦJ%����	I�ܘ�Z�}�*�s�5�〰:��8���E��\")�7f�/�ohD���Aꂇ�7�`����)�(�\0͐ѹ\n���<��A\0ue!��8���\0l\r�*�7D�(!�0�PAO�,o��:�PP�Kב,>�[�\0C\naH#Aê\\j/;f�@�S<��keA0��[��*�sѧ���Dm�9օ��0Y��Cؚ��d��ǆp@�*ntA��2���!�t�պ�^�]��v�%�'x�zzc���P}h��VzoT�7�UMO|h����	^͈�U5�G������qlt~�O�xt�du;o����S�d����it�-Ѻ[&�c�v��wl�rn��޻�L�S,x�\$���~Ck���1�����<5��\n��5�Y���ճ\n���}�V��Y_f��v��0%b=��7X+��f�J�8ׅK�\r2���� s��C�a� �1ݻ�br�:�ǜ�5Xl/�����kZ2B�U�%N���W��H\n\0��R�P��V���C�����'(��p�e��p\\�#�}����m�C��S���;�X��c��J����w�0\n�ɹ��\$�3������*+�xN~\r�t70i�b,n{�-��>B<��f)�V���s�XT�Y*���]�����杹7n�M�R)u�i\$..R�+\$�����CLp��`]8q��?�d�l=�pu6:d�1��P��C����s	p��wτ[J�]'�We���i���!J���,Ƭ�0���QY!BQ�.|,���l�܉�\n�U�i:�V�J�*����J�\r2v�GV�[+�\0f� ��� �2ܦ�a��(J�w~�G�9J��^�!3lDE��Zs1��u�\n.��p \n�@\"�{?i�&^�\nM�[^�8M�&�9��2N��pQdՄ�%LxY�#�ZN]��*K�_\r8�	���X��Tҍz}u�?��xP�_��d��Xi�������U����!\0ѵ�G�}\"�=����gݯ3n\rJ�\\P���L����_����l\n��_\$�憵�/fp�h��*Z�l�Dd����&A�)\rE�ܣ@_��g-���S8|J��\n�/�(��B��²�Hb�fҍ�̆/-�\r �,�ʊ�+\\?,6�obK@曉���r;���l�+��L��2�c���^	d��Io`�%�.b`����eF�D<'�C��+��8�v,c</��Є�ʞ��r2'����.ڥf&h�T�\\N ��+\$(S�|�#��Hgh?������DS���#��oj;�n���þ��E�8�B�\$^�\"�a�v8\"��p ��\nb&�I�}�lB,�dj���� �	\0@�D�\r\$��mŇP���V6����{�XX�� @�1JI�t[&�'e�\\D&qn�����rU#�0�6�Qxm	܅\"��C��m�����Q���1�m�E���b&+��q��������5����[fєDF�k���2��2;�9b�	�9C( ����q!�\"#&Xq�g��,��W#ւ�9�gf{\r�(�@�D��g\0�F5\0�؇�BJ:XD`��v����)'E�[�v�\"�[�6[�~G#�\0L6b\0�k�)�x9��Ŵ;��%&it�P�D��\$P��ة�f�b�rFI��~�v��rA�ԇG�Q��e���~�%�D�G��ESŸ��0!NA�n��8CQ.ϒ|�-	�p*|�-�7��s|�:ѥ2�~�+��J��ɎD�πjɄX�n��)��'oz]@�N\0�W�~+2���B�:��F+g�S�s�ɓ�3W)S6�3��Im9e�7C[.�:Ix8�}	#63�3���/��0��E��E�Lˏ�o�\"�R�p�sm-�pT�DE.��5E���BF�;���p�3S4\rp�hBtR4�=�<I�<��~����n��-1�[ɽ#�.�/=��F%FD��oOF�GF�11�A��<��#0�Gϔ���1Gec��+�+J�\r�J\\��_�8;q�GJҒ��ɉ8<dN��.�D�}�F�\\���\"��D3o4\r�H���t�E�N���t�8��~��G��2�4�����/2R/��t�\n�0��&s�Vd8�Ȁ���X\$�BREC��9��N��5B⇲��z�5M	3W	��t���g�;��;'�S�D��F*U2���T��J��P���Т��:��WSH��R�\\dQ.:�Ռ~��S2*�J��<t�~u���;��LU/AR5U_^t��5�tD�SVu�~�\$�1+2q1��25��& o� ��_rU]tKH��a��a���^�CG��H��b�c67`�#�_d5�e0w`�ye�A7��Vs~�â6��b	f��F�)*�[�x<#VwVfV�U�\nG6o�\$�_��jk�j�d�uH�OI4�jJ�j�AC3EQ��R�d�]��	>\r��e�Im��E�N��t�8���V��\\4��\r��o�/r�9��B�:.{R�0��>�r��Yn��l�Nw8�=k�v}U�Q�l�:�VAkд��lV�tg}u�)V�lgPSJWYt�qQwQ2�}+��[�#t�kS �׈��_yÍ,�+r�^�r7X5y7���>\\t��f�\n���L�7Ck��W�u��k��o5�~�p�_��dw�v)�w�����{����a��_6a�Wa0FCW�i\$�m�-o�I1�h�C|��H�=�x�C��L�k\0�N���	:��;�.��b��[��S�����������2�(�D�u�'&tLaf�I���ke\rIR~��Vak�r�I�gN4ȓ4�b8�;ezjp\r�V���`��r�{3[z��3h�5��Ά\r�O�\\���\n���pc��/�8��w)څ�cQ�-O�}Vh�5ؾ|�f͠	�ߑ@�.��fVp9�B 	�f��{�]�Z6�X�)K�3{8�9����B(w�5�vNf��\"���\r�vy'NrdY�v�.��\0K�\$�6}-� 'r,0�,�'4�;mXN�@P�@�ʩ/#Z��T�T���q%�h��/�SB�X�v3�_y�!N`�d�=��ՠ�w�8Ho�f�vfTJ�W�H�g��%�+���O=�f�4UW��s�8I.���P�zT�yPE�;��WF%�5�9��4��Y\"�\n���\r��H�g{b�S�(�Id[�z�p:#���zf��\"��;��;��%��1��gl�o>���<��H\\J�C��C��W��/U�H�p��m@\r���@��u����Wb�|v=e�>����;hq��@�	\0t	��@�\n`";
			break;
		case"tr":
			$g = "E6�M�	�i=�BQp�� 9������ 3����!��i6`'�y�\\\nb,P!�= 2�̑H���o<�N�X�bn���)̅'��b��)��:GX���@\nFC1��l7ASv*|%4��F`(�a1\r�	!���^�2Q�|%�O3���v��K��s��fSd��kXjya��t5��XlF�:�ډi��x���\\�F�a6�3���]7��F	�Ӻ��AE=�� 4�\\�K�K:�L&�QT�k7��8��KH0�F��fe9�<8S���p��NÙ�J2\$�(@:�N��\r�\n�����l4��0@5�0J���	�/�����㢐��S��B��:/�B��l-�P�45�\n6�iA`Ѝ�H �`P�2��`��H�Ƶ�J�\r҂���p�<C�r��i8�'C�{�9ãk�:�ê��B��} P�\r�H+%�����4 4��Jb�J�=#\"7#ʈ��>C{��?�\n0�l��\r�8@���S���H�4\r�.�����2�\0x����3��:����x�c��\r�#�rJ3��_X?��^(��ڒ��̒ǃ�����x�\$��>���,�#�|��,�m4#�2492+�ڼ6ʝO�N���'�����}	�E�R*��\\鄣\"l��N3��-H�<�+t[w����'��K�4�\r4��pT�zB�	?|�wiN�փ\$��h%�̢D�fC43E8�.��:�+f� ���1�-H�ϥ�p�����F��Թc�i�(�����C\r�5��M���м/�`xi�O\$X��B\0WƄ���������ꔥm��s�5�H�|��JW���-�:iu���� ��q�����d�d:����'^O��.=\$�J|5��AÄ0�=A<�v9eU76Ԃ��.���!v=��&`��n����[��I�4D�#���A�(aL)`RQ�8!���i�����N���=n�����Z1'ĝF��\"�C�*d�陓6K�\ra���:G��\n�]��~�V�X��d�� I�z�\r����U�pV�>=p�X�W���5���x�*���4Z|93\r��:�P�^�fC�u� �0���^Ha!�P@YCHfWG���x��dr��T����P��t(mD�D(����XKc,����rZI-�Կ��s��8�cH>Bi��F�BnH��`F���2[	��\$ͨO�ej`�9�\r��50�Ɂ�ƺ��b,a1R���\nw���d�D]��N�I�#�ɺ� Iª\r�z�R\$|#�!R(��r(�E���0PQ`{P3mMu�TQUHa��9�,K�C�s53����ԍF.B	c�\$��f|G�B\r3M� ��6CI'\n���-���ٓ3\$\rU���\n��VLh;�\0ƎgW���T�AG���\$�����|-jF�D��,�~ �&G��@�\n#�-	 ��J�9�33�Z��'��؎�jtOi�4a��3w������꽹�^�x3@'�0�kH�V��<�w�[,��*\$](�hH�D���P��c�b�/�8T,l@\n���|�C��H>\06�Uo�\"����\r��M�=�6�k�#r.B�7]D��J��1p��q(%���p \n�@\"�A\0(	9]�Îi�  ���O+�{AH\n�H\"�����N#�� ā\0S:�\\2�ˑYM�;�3>���;��6\\��r麐9'L��\n��9Ad:߄Vo�Cvq�eT[`,ｦ��9�\n��/p�\\��d�G*awnuüF~����v����,\n� ��\n���^��D��,����/h:J��PZ���N8��B\\\$q&��/���\n���Q��/B��	�s��͘����Âzg��9�,�M�59t���K�a9��#��̚�(���#R����hi��� �B�{r&�*��D����GL\"<��o�\0�E��d=ظ��뒲]z��J�^� ��&N&�����	�&p��^�F��N_:<C	U��m���\r��e�5�PlC=-9������c�}e�!ʎ_cp�y�7G��ȮZ1�r��p��H��.=�y�ބ��S�Oδ�>��tQЉ�h��:��:<f[{0��\0����&�ߜ ���k��z��~}P�s.��ȿmy��9����̯�ҝ���RI�#p��!��,�8� 6p��w G�;�P�D<�O>�`�:/R�z���\$r>Y\\�O*9��ڔ�Lfd^�)|L��@T(T\$D �E���0D�b��o9Q���L��LӉâZ�_=ڑ��~����O��_�N̓����U��\\�6b,�\"�xH�\nȸ��l��/��#P\0�e�\0o�_�rw�(go�:m�#��R/��b@��\"Kd�E��5FH��Ǡ�*`��%�G͌����O��p� -�`�.�,�L��p�()�s�fPo�x(���'&}捈���T�q0���������f7�颦b���n|���7.o�v(�4��\n���-ʾ\r��/�����;m�nP��p������0�\$��~��FoLbb�F'ˤX��\"#��G��V�Wq 8&.�#�t�l;\$���7��A̺��Cj>)�gZ��m��l�a�`8*9M��p�iq��������Q|�_M����N	��C0j��pyG\"�q� ���dd��vG��G��7.�'ȓD�\r�ѻɁ\n/������F�;�*\\d�%�#I��r!!f�:1� �\"D�!�H���\$/��:�W���=��I�S�`��!&�/���T�{��'m\"�%�ާ�\0�����M�%��(�&J�)q�Q�;��.B�)/���&Q�+�<N���Z��B�u F��@]R�4,L-��!f4`l��(*�~NX5��\$C��)�00<,OFZ�0�c.c1h���N���/O��&���� ��2�l3�6^R\0@d�\r�V���b+8��j\n���Z�����ܙN�LP��ֽ)���3n2��Q�����&\"STt�|H\"��c�\$B��\r�O�e4�8&S�6f6*d,���(ha+�~��'�\"캻c�\"+��R0:c�'�xfK'cr�\0�]�T��țǍ1T��K����N�1�����O(�,1D\r� k|�Q\"B#�&tGC~�Q�\0%�BnB˭.@�R�K��PH�\":ǃea>m&̋�����8�TO@�� \"�\0�5'�#@�_���e ��7�Kc\r�`x���\0�R��~\"�*Ԅj�&GC��\r�t�>C�P�\$j\r`�d�\n�l�i�\"@";
			break;
		case"uk":
			$g = "�I4�ɠ�h-`��&�K�BQp�� 9��	�r�h-��-}[��Z����H`R������db��rb�h�d��Z��G��H�����\r�Ms6@Se+ȃE6�J�Td�Jsh\$g�\$�G��f�j>���C��f4����j��SdR�B�\rh��SE�6\rV�G!TI��V�����{Z�L����ʔi%Q�B���vUXh���Z<,�΢A��e�����v4��s)�@t�NC	Ӑt4z�C	��kK�4\\L+U0\\F�>�kC�5�A��2@�\$M��4�TA��J\\G�OR����	�.�%\nK���B��4��;\\��\r�'��T��SX5���5�C�����7�I�����{���0��8HC���Y\"Ֆ�:�F\n*X�#.h2�B�ِ)�7)�䦩��Q\$��D&j��,Úֶ�Kz��%˻Jܷs\$PhI*��S2g4�MZ\r�\n���BX#D�&�.i�%.�0�|�L�TR�OI�@hhr@�=��\0���#��S�AGu��,��a�ü7cH�h-e\nO2���kMr�ۭ)�SHTIjfB�V�`���4�L�,ɐ��>ɫ)�F#D��pD�kgtThM��옗�;r�F��M+�# �G!�#�RP�&I�\0�1�n�����1HN@�4��0����9�y�\r��3��:����x暈�5�G�����p_(r���K8|6ǎD@3G�k�i\r��^0��Z��1|1D����K�S����ը��]�pj��`[��Y�tAi�S\\n\$ش	#f��������cG� P�0�Ct@3�!(Ȃ4^�݂s�v�|�R��ew)�\"@�������n�%��K#D�(�y|f�N]��_s���׺�:��P�0�����5~!�Ѯ����B����s�F��K\"0��j�W�/^oXǒr�B	[!�u�pL���U.}\0��`gHq@pN\$h	Ex�3�\r�]c���Cr\n!1��H �вSF�Ģu�JO��B.Q�4���O)d�ưC���L>&ɤB��8�ɡRQH��S7�ы�~ą��3^����C�����[���cX�Īd��&E�a��b9�?1��]����J5@��c�Vi�����C�\n8'\r����0lc���Ш�[j\r��U�YC*ϐ���\0sL!�9J���\n 	ڱ��N�(`����v��j�t\0�!�0��|y����\"WS�F.�TF�U\"P�\$%�o)�D�	1JY�M[�SRkx����qQ��m,:�����G)�1�5��?8�	�4f�ҚcNj\rJ�5P����/H�:6���kD-��-T�M�5�N0ȒT�TDbaE�	-)���\n��>q��e>��0�����OjB;�-�5�x��p\r-	*�\n\$�ZEh�%��֞ڋS\r��5f�֖j�Z+M�6 �C��\r�d:R�|���5u�`6��ْz9�U�1B�%��**d4�	g`S۹�tQhЧ�!?�A�d��i�f!Xb9��:���f�i.X��g\n崸F���{BF\r{��W����I�\$��f�La7�����n�H\n\0��\\����(,ঠβNS��YWE��#\n���Od�/\$B�<kN��:J�,!�9�D�W^�C�t:ǉ\$3{Pþ��8��cd�JE��>�!H�J}�G-��3��L�F灳��2�]gn�;��,(i�Z�|r!}��Q��n���b�G��T�j�����f��*���*���dWҚSp���{M��*�QM=�Wg\"}'�\$����ǃK�d\$a��3�u�q}A�%dvhEjc���9l���JP�D�cz�R�D�(�B@,Xr��`'�0�ddb̑>�f���t��*�����\n;���Eaeq�������%��Hy8*h�?�.p3�/F�j[5&Z�� \np�l�8�P(2`���Mxd��n�|��:=A�~ʽ�4��5�S/B�\$*J�4nAO�h/sL&!�'�Ȏf��!�h=!64#��*wȦ��Y�4h0���/�z�W(�\r��:CU�-�V?���:�?A�訠���3�L�]{��Ϭ�@�-��7�Lm� r�2Ȗ���jV_�CT�[.���*s��	b�_t���+�D�!�<R�ݳ�����M�?G�����8Џʎ�F�\n�t��l{�vn��N�8��E��;�&�\"*���T@��dh\"ڜl���?n����\"�ֲ�!���]��!��0�t��齒\\��LO0��U��n<����P��\\�F7NMF2h�\$r!�0�B%ܬF?�d���\"�\$]���M�J?�r�/\"���%-�8a�r-�x��r�[O���/.v�Uk���*d��،HvÎ�oB؜�%��\"�p<)���K'Qn������Î�\$���ʐ(F5�Nc\0�\n��`�\r����I`���J��[�0QHʨ�Z�oGj��v��b�Gr7�[0��ʧ~҆Ȍ�M��4�m�.���֝��\"O�w��\r�G\r�.U����(OV��?(�.0��\$ӑ��@P�\r,�¡�3'��_\rxw�&3e�o�G|�k�Lq8\\�'�k\n�ob�\"����}Qs�n�i�;q��?�uȌ�Qxxq�ц�j5���-�G`�#10A'�&\$�B�aFA�\0��`���B\n�C@RQ��!j=	�]b]efP�m��M4n�� w�)�>*Q�-�v>CVQ�>\np�d���r/j�I����Gz�ų#ª4%�#CFR��DX����E�4�Z@�J�'�^.�41fD�b��'�I(\nw(QF�0�ұ2(%�)i�B�a�o��o�҃*��쒞xϼ����VK��h<-od����r�6�*��%L&���s�oG*\r\\a�\nj�\$��d#�6S/8��*��v�\"A�4�ꨎ���#S0tD�{���7.��4����0�%0��)/ڄO�r��)�5-�.s`؄҄��z�BA�F��P�N\\\$�`.94�f_�H���+�3,2���:.�\\����4��NR�r_���,`s����RR�\\3��6�ֺ�ʋ��)�/,S�3�������@�@R����>ʜ�\r�\$��6����'5\n��C �PZ�	,L1���=gE��t*S�yC&�!+C�OD�,ѣD�/D�o-�ET\n�\$�t^\\b1<��^Ll�R���D�qA��!m��\0��24M:;� ԫ\0gB2���uA�%JQ	\0000�LT����>�=����l:0�.��;g.)��.�W%u>;f�'���6��*s��#��O��n��3b.�>o5æ\"�.�t7�,��|��Ⱦ5%9P<Pb��Ҵ��Ԯ��^����p1�<�o�sn����(���=�U;�_�\0\$��rT�E�nc�r/�Kr�K��Z��Z��&�K�\\.�q��7p�4)[�:��5�+ԟGt(�EU�@q\\\r>��#)�OU���R��+�:�*jp�]ҝYg�&ON�H�.���Je 'O].H��b�n\n��]��+\"��IFg?T6��\\VYvKDaB�_��MU��d\$��G�s�&�9FT?e�.�V�(�`��3�[ir�,����3OV4+\"���N�9�Pk�e�MVb�;Vg�5�gv�g��m�ʳV�b��^vg=���H�m��EM�n6��v���p�М��P��K�;>�rV�Y�pf��y5�j��s�L��V�]�-QoեMAEu��=t���p2MvAq0stwtS�&���]NH]��/awS[S�x�xː|\\3Jy^ל^7�^��f75_���O6CH�f�\\啋4��&�}+�h�{��k���C����/Er���c�&wU/C�/w�����Qs�n�G�xU_y&(tM5yb����Xt��gS�M\"�Dr�8\r�W�^�MI�<S?�鄘[I��\0����ul�,9o�%3X{�4�B�8G��t�R�;\r�\nIL|�@�\n���pX��WO��T�7�<��w8S�G�)��{��Z;�\r4�s8ߌ��o�[�@\$T2�P���Gtr���@�\r����A�da�t%2Z>�J@�`[U�w�N�Va)َ.S��&��=X���<C8�c�x	�����hF\\<���upn�h�x�!*�5Y����N���'����W�÷�1\$6nqr���~U�.�)\\Y�/���Y()�W��v�X�D��mk?,����R@?u���+r�'\\ϴ�B4	���:��}/��S<�\$X=Md�s�OK�A��Sx�s|��\0�3�'*4=�����d���ۢ9轃}��2~���e��ad�+��}��F1�X�=&�+X��v�����g�1 ����t���&�U��f\r���;����CE��S?�02��%Q	ax@��";
			break;
		case"vi":
			$g = "Bp��&������ *�(J.��0Q,��Z���)v��@Tf�\n�pj�p�*�V���C`�]��rY<�#\$b\$L2��@%9���I�����Γ���4˅����d3\rF�q��t9N1�Q�E3ڡ�h�j[�J;���o��\n�(�Ub��da���I¾Ri��D�\0\0�A)�X�8@q:�g!�C�_#y�̸�6:����ڋ�.���K;�.���}F��ͼS0��6�������\\��v����N5��n5���x!��r7���C	��1#�����(�͍�&:����;�#\"\\!�%:8!K�H�+�ڜ0R�7���wC(\$F]���]�+��0��Ҏ9�jjP��e�Fd��c@��J*�#�ӊX�\n\npE�ɚ44�K\n�d����@3��&�!\0��3Z���0�9ʤ�H�Ln1\r��?!\0�7?�wBTX�<�8�4���0�(�T4BB��-Kd�P�ɒpS��Z�&��;�q�&�%l��%Kr!��\n&�F/c,6J;rb!�åh��,��Vej�E�-@]��8�LB�6�o�	AP�AÔ0�c\rI������;�(��:��\"9�p�X��9�0z\r��8a�^���\\0�w+����}�x(�2��\r�������҃px�!�\\,���˳4튂h	K)Ft�� @���a�V\r�K��-��B��9\r��Ί�\"�<�!@�� ��N�Đ��I�`�0֪��J��h��lp6AC��6�(�1BT��Jv7oL2pJ���Gg����5�%���V�]�3ɆQ7,tW�ëg�	}��6�C��(,� P\$�������L�Ѭ�(��S;��F�B��q�bR��\"��&C�z\r��436�J���\"|�?�<�� �g�*�@�y�Ͷ���GKK��\0��j�٬����s³IB�J�Ť������&Ķ5z�с�2�\0�����0���8@����\r}���� n�,4�B��L�Z�0�I�E\$�=���N�U�Yxh6\"�E�f#��.���f�+n�(7P�K�bBt�A�2�PߐR�84�􂙒��{�1%f��aԗ,�ڿ��\n�3�E0�;1Q��z�Ĺ\"r`�J��ȹ�H al5��&�X��m��\\�n�3DP�A��Qѱ3vrK��h\r*��\n�v�i;H		����\nyoFnH1B�ՠ�V�=��U5�\nw���0�Ø�b�Y�1�9(��L����\"���eA�s�A�	2���c��G��+t�F���Ѕ�lj\$D��N4��D@k�b\"�@�`l/(8i4C+f!�H��ּW�f��6��A�&�\r�\n�%8n��KB���кCI�`#\$H[\rV ���n���H\n�Й�<%�A8HD�\0��.�\"c���:@��I�P!���\$����t�����\$U5�>�0�A`JsB+�Ǖ`���pp`		!FOI�U\n\\���Һ�AQ����FU���-R*�l蘐\\D�HA�V��F���9w��6�oD�t-E\0���E�I�?���\r\"�\$�\$� ��\$��H76b;`Xa�@�(3��'��Ch��VD�k���k̒<Q	`/\n<)�H�w��9��\"?���۹3#����QH�'a�m�Eڡ3)�_龎�ٟ��B1��H�\0 ���`�X�|ܐG>\0�e|rV\r�X�1\$8����q�嵬��b�%���q6�,I\$��U\$�\n�H@���LK!��a�X�!\n�]�֪��I�8K=\$���A	V\\-\n���b>A�i-dl2aD�wr�	����9�@�`�,�.G�t~o�9����sSy�_�f��L����Е\"/��L�ː���\n+\rc��I��f���=z�*�|n�)�E��=��(�-	{Fȗ�\$MI�9!�tV���N3s����˳9�i%Uj%t�G�}���U��P�bډ��\rV���<\"j��i����\0��:c�%TH�Վ^ps�\$|���Io҉���*���7Z��N��E�\"���.\$��2��%�\\�3VJ�̓5P���!�*�l��h�BT\n�!����D<�k��l�B7bM�P����!��i��� s d���[bĝ�N{�\$�-��l,앎�=��ir,�I<b���[�%SC\$�4�n��	��r\n1w�L�1Q���>F�Q��Q���Os�UI.E��J7�}N�{O���nQ&�S17�N\n�\ng���8{���0�|'����^:�N�|��_�n��\n9\"�qe��Pʻ����+#D�m�D�*+o�#�@m�ة푿%����%���	�~��H������F�m:��fk ��&�R9��2�r�&�J��ɤOM\$���?P)\0~I�uf��F�Ab-�JB�o:˄9�T�F�Z0,Fa���6M�\n�0�6�.�'C����ǈm�f�M6�D��-,���\0-�ˍ��*�D�G�Bi\08~�	��Ҩܨ��L�'�P�#��0��\\��I��Tϐ?\0\\�G�\rbH�c\"����	/�/�.+���#\0Ð5�\\\"�\$�\$湐���\0��<�\"'lrt�H\r���VF���E���\n�	N8�1����&~��[\r#�&J��J*�LH�E1J��duN~�.:�1d�ĔjF�\0�P�Q>j�Cm�jb	�1�,�)�����G�\0���K1���9.vhp�}��p� Qr|�ӨQ r�\"o��-r����^AN��r	nL:&�NAvI��i�Fn��`�Ȃ���Q�r\$�j\\�rv�I- �����\r�Z�J�.��M�\"����E}�'b�9�VO��P�(�'��2	��P��e�+��(2�V�-R��2�L��&l�,H/���*��T<�XX��/��\$�x��,�	1m1�����NCr�26�R�3S.}e\\\$��\\�\",�P��B��e1Ʈ<��V[2r5E�6Q �0n�L�͋�4Ά�%P�X0�('s�5f��)�:�M�#s��*:��ǫ�Y��Aw:�l�x�o%R�%��C�J ��-\nT�'H��Mw&�\$�G��1bH��vW��cJIEr ��\n���q\r�,��Xl�m�Ţ@��#0gZ5��0�\"LR�+�p/�t]N	>��(SD�r��6(�jqfzn��,���06d�Y�I��z��̠��<�\r&%S|Fa/��l��P��;G�\r�HH����/Is�J�}�\$�qJ��9�~j���=!c�v�E�cJq��IO� }#x�#�ڪ�m�´ph ��\"i91��BK��j�(������b'8�`@}PZ*�\"I����K�́^0���*�\$���Ŗ\$�v �N�3O44jϨ!V�IñKK�@�����R2�-����2���S��3��[�F��-�4b�";
			break;
		case"zh":
			$g = "�A*�s�\\�r����|%��:�\$\nr.���2�r/d�Ȼ[8� S�8�r�!T�\\�s���I4�b�r��ЀJs!J���:�2�r�ST⢔\n���h5\r��S�R�9Q��*�-Y(eȗB��+��΅�FZ�I9P�Yj^F�X9���P������2�s&֒E��~�����yc�~���#}K�r�s���k��|�i�-r�̀�)c(��C�ݦ#*�J!A�R�\n�k�P��/W�t��Z�U9��WJQ3�W�q�*�'Os%�dbʯC9��Mnr;N�P�)��Z�'1T���*�J;���)nY5������9XS#%����Ans�%��O-�30�*\\O�Ĺlt��0]��6r���^�-�8���\0J���|r���S0�9�),���,���,�pi+\r��F��e�b�%ʁP��˽D��F�/��@��[r��)3����J�<�E# �4��(�t�d�lR>����\\�.D���/�r��Oi&����\r��3��:����x�a��\r%JR�p�9�x�7��9�c��2��:e1�A��AN���IX��|GI\0D��YS1,ZZL�9H]6\$��O�]FJ7\r&��ギ�i,X��uz=��ZS�����8tId�K��LW�eE͍�9Tr�PDO\\�}�L�g)\0^]�}�T���v�x9 D%��8s���N]��\"�^��9zW%�s]f̲��:Da&�I�\\V���]2Ą�!fD#�ECGm�l)�\"f2�n�I����58V	�Pt+M��'1Q:����\\�)�q�q�SGD����l�^8=9�C��\"]M|�I�7�\\��|.��^@P�:Ijs��qt_������wYCQaHX��dV.LC<C�\$�`�(��C\$��H�26W���jÑ\0�)�B0@���9F)O��g(�+���a�#_iK\r�E	����a��|tD���R*MJ�'�+Ÿ�t	�\"Q,'b�Y+El�ҼW�a,E�J�Y�<�@��t\r0�l��f`�!� t�bOH���N�\"\"A��]d`^	��j��Fp|[���yW#(�?�,,���*�Un�UڽW�a�u�����Y�9hP�xs�kAm5�RA�eu&2H�E��&�0W1�,��\"r��,�����(�H%ӺHb�����S+E �b5��UQ,�aq6.H�Un�V��ТHH�AB�����dU4�L��R�<}UX \n (&I\$�|�,��x�F�5&�xOa)R\0�ND�qV+��1���{i/��̸� NYsA��q�(��3�W�Ƅ&(\0���Z*!�(���-i4P�l�E��%���OlN	�¸Z�Fj�a\0�fl�P%t6���1��RQ!v#���P�k\$����Y���.\"�S��\\(�ʭ&,�R\nz���8�(\"EΥ�E)*���|t�V������(t�s� \"�1�P(�B(	�'o�0��^I搜NI�;wP`�ؤǕ�Qt�+��\n	�8P�T���@�-�-\"�Kӱj��H�K���*/� �g�&(ړ�qf��0&��EE��w`��qvt+�vG�\r�t�s�̹�W��.�༯�u�f��D|9�@�di�\0��jYDQ���=,?��Є��1���8�A�]�(����Hs9����Ai�M����aB9�s\$������tb���.i�<��)�3:B�����Z`�p�)ǰ����h��M�1@!�U���W�chģX\\Lb'S�|݀�˂G/�6.�0�\"L_Oc	B�Yh���۱!~/�`y'�;V+�0����6Z(�bC	��1Dcth��N��8x ��T��E4����+\0J�u��@X�Yvcf§.\0R�D�DL�3X�jt�'K�����#Ms5Ln��k�˶��bq=@���m�c��o*��'E+-IŘYü�(b܉�/YQm��(S>�*�E��5(V��v![J�_zT����z\"��U^��^��u\"/�c�t.l�1��a��9�rm�WH��\\����揑dV	�9Ja�c���|�r�G3u4+�#:g���%p~sX8�_��t�J�DGI�䴳�҅�p�����V���B*鬎%�k�.�4W-<䊋�̱}��O������swd]`_����%�ƎW�w�s�9�Y�b<�����xP�?mA_wu6��{kVj��x����������Ϡ枣������(��Y6����9eL�0XqSLi�\$&Q:s�����@��Odd�J�B�5<=��2%;�Un����2iM���3't��KMy�	����r��+ǌ#�:��/�G4��Щ�tςR�/L`��)��bP\n%�\0as&��g_��p��-��2d��,�F�i�\$�x4���,���!Z����oJr�L���%�\$k��hM���b���pvhl�{p�3ϰa<����C��fG\0��k��\0P]\n��/OU���O���	�\nP�F	��u��O��l���j�0f�L���\r,�N��bP���pGP%\rà�0�\r\$HD���n*��Z`����0Vl	���(-!t����B����Cb����\"�H\"����B|\"�qTJQH��L�-V �Z����@g�\r�z���� 4.�Gɪ�\$&�O��i�;��\n���p6�,O���B��D8)�#b:��~:m�a�Ы��!(4��!^��p;(2 Cn/��ͩ���^�vCj�zhC4{�:-2!�Z�(�JJf�\"Z!\0.p.��B�����������CI�m%���nl�!x*lq&�X4obG���ώ4j\"iL�\".vnzs�̹.��N�)n���\$�pDM���\\���`� ���\r��\$2pΐ_��G#��`BbO�G\$���T���@����.��2�m���r�\n��Ҙ���{��r�aL";
			break;
		case"zh-tw":
			$g = "�^��%ӕ\\�r�����|%��:�\$\ns�.e�UȸE9PK72�(�P�h)ʅ@�:i	%��c�Je �R)ܫ{��	Nd T�P���\\��Õ8�C��f4����aS@/%����N����Nd�%гC��ɗB�Q+����B�_MK,�\$���u��ow�f��T9�WK��ʏW����2mizX:P	�*��_/�g*eSLK�ۈ��ι^9�H�\r���7��Zz>�����0)ȿN�\n�r!U=R�\n����^���J��T�O�](��I��^ܫ�]E�J4\$yhr��2^?[���eC�r��^[#�k�֑g1'��)�T'9jB)#�,�%')n䪪�hV���d�=Oa�@�IBO���s�¦K���J��12A\$�&�8mQd���lY�r�%�\0J�1ġ�D�)*O̊T�4L��9D�B+������Y�qb����*��\\gA2�@�1D�O��V�%�^R���pr\$)�L�`P�2\r�H�2�GI@H&P�pF��	h�SQ�1�M#��%*�!�`x0�@�2���D4���9�Ax^;�p�TUU`\\7�C8^2��x�0�c��p�xD��AR�d)�SmR�Q�!�^0��pt�%�4CϘBW��!u2���s�\\���KOX�,J3�:�1�uDM��ZS�����\0�<��(P9�*iXBJ�Ty<EAvt��C�\$Y+�G�fW�-jՂ`ę����^�6C����↸��vs�|�s��I�GO޺��D1Ta�\\y�z���P�2��@t����S%�R\0N%�+�63��A��~�)�\"`A���K�s\$���6�f=��t����<�&�b�X]��VE���'��8�D�'�s�R��Y]%����v͔������{L����\r���˕I6Q0D��]̵GMy��v���c �6�X �(ib��RY�äHQ|#H���S?\"4�B�)� ��o\rk��@e��B�������%�r'�E&�H��8��V	�\0�EB�U*�9@W| ���C�\"kD��Y+-f����֪�[+n!����� /��7�c\"�ØF�X/�`�-��a9Һ�\$0D��\0���e]1�7:4W\0RDF���Ŀ56e���@�)'���K)f,場���[�m-Ȉ��\n�\\�!����!r����r�+��q�`���\\\$�3�SʀB��,e�����_��A��MI��\"qZ)ЍreC�c3�,5��4s���\$!6�H��4�����O�s)��%���3gH�K��΋H4@PL�����!#�J��AY��bL�P�nb��\"X�����|A��:Ĉ��%��\n��(�X*�I�Z\0.�s\nx�Wџ>�^�a0+���Q��K�-��M�BXx��90�\"hM���� �\"QgP��%�BTsg�D��S!�'���3,͗Y�'��P�K1b �P��q&���5������\0�  R��\\�\0���C�/U3��q\\UrM���z�U�Ш�M��5\0B0T\n�2�P��	�����ȡT8�Q5&G�r�%� ��b4Z��@(JU	�8P�T�*�\0�B`E�L�Ҥ\$h�&d�G�Ă�o��q�8]9�ɌA�1�<�3�NȨ�:��E��0)߸�<\$e���l�O�ۚH��\$e�Vv/Eޚ�4x�ȕ�A\n�ݐ��c���\$0\"�\0���Ո�]aI��T��(E\n��5:�4J���L�Y>��`aU�1��`X%W~��aDh0dW\$I*�����N�\\,���z|�D����ʰ�)���\nf8_����Z\n&���К^h��9�А#���^�0\rp�B���x�8��W)E='}�u�S�}Pі x��B~��^5��|�x�k����m�K�\$zh. #q�բ\0���*�1�^VR�m!R����|��QTxA+1���Y�B#	t�2�DR�0@�Z��;�F�\$/E������|\$](��\nzOm�m\$8�l#;n���ݛL�p���Ѐ��x�Aos�9�Ą��X�\$�D��N �h/�u�� �G�,(\r�P��Rqܟ�wY&)�`]mԔ �]y���/Tt�v�>�����)���\"0`�-HräA��S��8����i��K�Y�4�%�NXcs���9�ՔW>�,�><���%tK �\n�a�L\"�[��W��(=��sOV�V�,�x(?;��F��v�]`��_K~<�.-=�)�]�t;��53�~�Ҥq�n>>�)|݌��X��S��/�����\"[�=� ����L������/�y��]������	j#Ծ����t\rϼ������}����\$�뢺aj�jv�ӫ�\0Ϩİ\0� ��\"�!�C�ҁP5�\"��U�%�n3�ʜ�O�z�����Ҭb��:��n�#\\�m7�>���.{_⨛�h�p�˫p2����H4�21�D����hc&6OP\0	�ϐ�6o�İ��Ь����QL9\rxm!m\0��\r-}�\r�֪��Mz���p�`a,��&w!:!��溛���'��7b�����Mu\r��\"� ���[�\\n�!a�k-l��rU�~*�.�J�F�E�U�q*�G�G��P��#-�A/P�Lc��c�}������ı��/�]�p�f��M�ԑ�v\rQe�OMk0�q��-Jı��Id�I�����dlG�d�0����A���,	�\r\0��1�t)���Fz!D���C�@�i`P�@R�I�DJ��c��az#pkA\n. C0�B�&5���ABA1O��dN� g�\r��'â9�'�\\jD�2��D�M��*\0\0�\n���p8����. ��8if\n`��K�+�`k���0��8���ǃ\0r���Sn�f/�b�(�)�ԞA:3\nur.�r�ho�D,������3*%����l�HL��-o��W!c���'��P��	�v!�l��%��\r�/���0�f�q�7�v�,\"�6��ň�\n��`������\0��Z�j��F2݆<�AR�s&z/3, ��&�,G=lC4e���gYD#!�\$�\\*���� �/��";
			break;
	}
	$zi = array();
	foreach (explode("\n", lzw_decompress($g)) as $X) $zi[] = (strpos($X, "\t") ? explode("\t", $X) : $X);
	return $zi;
}

if (!$zi) {
	$zi = get_translations($ca);
	$_SESSION["translations"] = $zi;
}
if (extension_loaded('pdo')) {
	class
	Min_PDO
		extends
		PDO {
		var $_result, $server_info, $affected_rows, $errno, $error;

		function
		__construct() {
			global $b;
			$jg = array_search("SQL", $b->operators);
			if ($jg !== false) unset($b->operators[$jg]);
		}

		function
		dsn($nc, $V, $E, $Cf = array()) {
			try {
				parent::__construct($nc, $V, $E, $Cf);
			} catch (Exception$Ec) {
				auth_error(h($Ec->getMessage()));
			}
			$this->setAttribute(13, array('Min_PDOStatement'));
			$this->server_info = @$this->getAttribute(4);
		}

		function
		query($F, $Hi = false) {
			$G = parent::query($F);
			$this->error = "";
			if (!$G) {
				list(, $this->errno, $this->error) = $this->errorInfo();
				if (!$this->error) $this->error = lang(21);
				return
					false;
			}
			$this->store_result($G);
			return $G;
		}

		function
		multi_query($F) {
			return $this->_result = $this->query($F);
		}

		function
		store_result($G = null) {
			if (!$G) {
				$G = $this->_result;
				if (!$G) return
					false;
			}
			if ($G->columnCount()) {
				$G->num_rows = $G->rowCount();
				return $G;
			}
			$this->affected_rows = $G->rowCount();
			return
				true;
		}

		function
		next_result() {
			if (!$this->_result) return
				false;
			$this->_result->_offset = 0;
			return @$this->_result->nextRowset();
		}

		function
		result($F, $o = 0) {
			$G = $this->query($F);
			if (!$G) return
				false;
			$I = $G->fetch();
			return $I[$o];
		}
	}

	class
	Min_PDOStatement
		extends
		PDOStatement {
		var $_offset = 0, $num_rows;

		function
		fetch_assoc() {
			return $this->fetch(2);
		}

		function
		fetch_row() {
			return $this->fetch(3);
		}

		function
		fetch_field() {
			$I = (object)$this->getColumnMeta($this->_offset++);
			$I->orgtable = $I->table;
			$I->orgname = $I->name;
			$I->charsetnr = (in_array("blob", (array)$I->flags) ? 63 : 0);
			return $I;
		}
	}
}
$ic = array();

class
Min_SQL {
	var $_conn;

	function
	__construct($h) {
		$this->_conn = $h;
	}

	function
	select($Q, $K, $Z, $rd, $Ef = array(), $z = 1, $D = 0, $rg = false) {
		global $b, $x;
		$ce = (count($rd) < count($K));
		$F = $b->selectQueryBuild($K, $Z, $rd, $Ef, $z, $D);
		if (!$F) $F = "SELECT" . limit(($_GET["page"] != "last" && $z != "" && $rd && $ce && $x == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $K) . "\nFROM " . table($Q), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($rd && $ce ? "\nGROUP BY " . implode(", ", $rd) : "") . ($Ef ? "\nORDER BY " . implode(", ", $Ef) : ""), ($z != "" ? +$z : null), ($D ? $z * $D : 0), "\n");
		$Ih = microtime(true);
		$H = $this->_conn->query($F);
		if ($rg) echo $b->selectQuery($F, $Ih, !$H);
		return $H;
	}

	function
	delete($Q, $Ag, $z = 0) {
		$F = "FROM " . table($Q);
		return
			queries("DELETE" . ($z ? limit1($Q, $F, $Ag) : " $F$Ag"));
	}

	function
	update($Q, $N, $Ag, $z = 0, $L = "\n") {
		$aj = array();
		foreach ($N
				 as $y => $X) $aj[] = "$y = $X";
		$F = table($Q) . " SET$L" . implode(",$L", $aj);
		return
			queries("UPDATE" . ($z ? limit1($Q, $F, $Ag, $L) : " $F$Ag"));
	}

	function
	insert($Q, $N) {
		return
			queries("INSERT INTO " . table($Q) . ($N ? " (" . implode(", ", array_keys($N)) . ")\nVALUES (" . implode(", ", $N) . ")" : " DEFAULT VALUES"));
	}

	function
	insertUpdate($Q, $J, $pg) {
		return
			false;
	}

	function
	begin() {
		return
			queries("BEGIN");
	}

	function
	commit() {
		return
			queries("COMMIT");
	}

	function
	rollback() {
		return
			queries("ROLLBACK");
	}

	function
	slowQuery($F, $ki) {
	}

	function
	convertSearch($u, $X, $o) {
		return $u;
	}

	function
	value($X, $o) {
		return (method_exists($this->_conn, 'value') ? $this->_conn->value($X, $o) : (is_resource($X) ? stream_get_contents($X) : $X));
	}

	function
	quoteBinary($dh) {
		return
			q($dh);
	}

	function
	warnings() {
		return '';
	}

	function
	tableHelp($B) {
	}
}

$ic["sqlite"] = "SQLite 3";
$ic["sqlite2"] = "SQLite 2";
if (isset($_GET["sqlite"]) || isset($_GET["sqlite2"])) {
	$mg = array((isset($_GET["sqlite"]) ? "SQLite3" : "SQLite"), "PDO_SQLite");
	define("DRIVER", (isset($_GET["sqlite"]) ? "sqlite" : "sqlite2"));
	if (class_exists(isset($_GET["sqlite"]) ? "SQLite3" : "SQLiteDatabase")) {
		if (isset($_GET["sqlite"])) {
			class
			Min_SQLite {
				var $extension = "SQLite3", $server_info, $affected_rows, $errno, $error, $_link;

				function
				__construct($Yc) {
					$this->_link = new
					SQLite3($Yc);
					$dj = $this->_link->version();
					$this->server_info = $dj["versionString"];
				}

				function
				query($F) {
					$G = @$this->_link->query($F);
					$this->error = "";
					if (!$G) {
						$this->errno = $this->_link->lastErrorCode();
						$this->error = $this->_link->lastErrorMsg();
						return
							false;
					} elseif ($G->numColumns()) return
						new
						Min_Result($G);
					$this->affected_rows = $this->_link->changes();
					return
						true;
				}

				function
				quote($P) {
					return (is_utf8($P) ? "'" . $this->_link->escapeString($P) . "'" : "x'" . reset(unpack('H*', $P)) . "'");
				}

				function
				store_result() {
					return $this->_result;
				}

				function
				result($F, $o = 0) {
					$G = $this->query($F);
					if (!is_object($G)) return
						false;
					$I = $G->_result->fetchArray();
					return $I[$o];
				}
			}

			class
			Min_Result {
				var $_result, $_offset = 0, $num_rows;

				function
				__construct($G) {
					$this->_result = $G;
				}

				function
				fetch_assoc() {
					return $this->_result->fetchArray(SQLITE3_ASSOC);
				}

				function
				fetch_row() {
					return $this->_result->fetchArray(SQLITE3_NUM);
				}

				function
				fetch_field() {
					$e = $this->_offset++;
					$T = $this->_result->columnType($e);
					return (object)array("name" => $this->_result->columnName($e), "type" => $T, "charsetnr" => ($T == SQLITE3_BLOB ? 63 : 0),);
				}

				function
				__desctruct() {
					return $this->_result->finalize();
				}
			}
		} else {
			class
			Min_SQLite {
				var $extension = "SQLite", $server_info, $affected_rows, $error, $_link;

				function
				__construct($Yc) {
					$this->server_info = sqlite_libversion();
					$this->_link = new
					SQLiteDatabase($Yc);
				}

				function
				query($F, $Hi = false) {
					$We = ($Hi ? "unbufferedQuery" : "query");
					$G = @$this->_link->$We($F, SQLITE_BOTH, $n);
					$this->error = "";
					if (!$G) {
						$this->error = $n;
						return
							false;
					} elseif ($G === true) {
						$this->affected_rows = $this->changes();
						return
							true;
					}
					return
						new
						Min_Result($G);
				}

				function
				quote($P) {
					return "'" . sqlite_escape_string($P) . "'";
				}

				function
				store_result() {
					return $this->_result;
				}

				function
				result($F, $o = 0) {
					$G = $this->query($F);
					if (!is_object($G)) return
						false;
					$I = $G->_result->fetch();
					return $I[$o];
				}
			}

			class
			Min_Result {
				var $_result, $_offset = 0, $num_rows;

				function
				__construct($G) {
					$this->_result = $G;
					if (method_exists($G, 'numRows')) $this->num_rows = $G->numRows();
				}

				function
				fetch_assoc() {
					$I = $this->_result->fetch(SQLITE_ASSOC);
					if (!$I) return
						false;
					$H = array();
					foreach ($I
							 as $y => $X) $H[($y[0] == '"' ? idf_unescape($y) : $y)] = $X;
					return $H;
				}

				function
				fetch_row() {
					return $this->_result->fetch(SQLITE_NUM);
				}

				function
				fetch_field() {
					$B = $this->_result->fieldName($this->_offset++);
					$fg = '(\[.*]|"(?:[^"]|"")*"|(.+))';
					if (preg_match("~^($fg\\.)?$fg\$~", $B, $A)) {
						$Q = ($A[3] != "" ? $A[3] : idf_unescape($A[2]));
						$B = ($A[5] != "" ? $A[5] : idf_unescape($A[4]));
					}
					return (object)array("name" => $B, "orgname" => $B, "orgtable" => $Q,);
				}
			}
		}
	} elseif (extension_loaded("pdo_sqlite")) {
		class
		Min_SQLite
			extends
			Min_PDO {
			var $extension = "PDO_SQLite";

			function
			__construct($Yc) {
				$this->dsn(DRIVER . ":$Yc", "", "");
			}
		}
	}
	if (class_exists("Min_SQLite")) {
		class
		Min_DB
			extends
			Min_SQLite {
			function
			__construct() {
				parent::__construct(":memory:");
				$this->query("PRAGMA foreign_keys = 1");
			}

			function
			select_db($Yc) {
				if (is_readable($Yc) && $this->query("ATTACH " . $this->quote(preg_match("~(^[/\\\\]|:)~", $Yc) ? $Yc : dirname($_SERVER["SCRIPT_FILENAME"]) . "/$Yc") . " AS a")) {
					parent::__construct($Yc);
					$this->query("PRAGMA foreign_keys = 1");
					return
						true;
				}
				return
					false;
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			next_result() {
				return
					false;
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		insertUpdate($Q, $J, $pg) {
			$aj = array();
			foreach ($J
					 as $N) $aj[] = "(" . implode(", ", $N) . ")";
			return
				queries("REPLACE INTO " . table($Q) . " (" . implode(", ", array_keys(reset($J))) . ") VALUES\n" . implode(",\n", $aj));
		}

		function
		tableHelp($B) {
			if ($B == "sqlite_sequence") return "fileformat2.html#seqtab";
			if ($B == "sqlite_master") return "fileformat2.html#$B";
		}
	}

	function
	idf_escape($u) {
		return '"' . str_replace('"', '""', $u) . '"';
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	connect() {
		global $b;
		list(, , $E) = $b->credentials();
		if ($E != "") return
			lang(22);
		return
			new
			Min_DB;
	}

	function
	get_databases() {
		return
			array();
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return " $F$Z" . ($z !== null ? $L . "LIMIT $z" . ($C ? " OFFSET $C" : "") : "");
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		global $h;
		return (preg_match('~^INTO~', $F) || $h->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')") ? limit($F, $Z, 1, 0, $L) : " $F WHERE rowid = (SELECT rowid FROM " . table($Q) . $Z . $L . "LIMIT 1)");
	}

	function
	db_collation($l, $qb) {
		global $h;
		return $h->result("PRAGMA encoding");
	}

	function
	engines() {
		return
			array();
	}

	function
	logged_user() {
		return
			get_current_user();
	}

	function
	tables_list() {
		return
			get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");
	}

	function
	count_tables($k) {
		return
			array();
	}

	function
	table_status($B = "") {
		global $h;
		$H = array();
		foreach (get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') " . ($B != "" ? "AND name = " . q($B) : "ORDER BY name")) as $I) {
			$I["Rows"] = $h->result("SELECT COUNT(*) FROM " . idf_escape($I["Name"]));
			$H[$I["Name"]] = $I;
		}
		foreach (get_rows("SELECT * FROM sqlite_sequence", null, "") as $I) $H[$I["name"]]["Auto_increment"] = $I["seq"];
		return ($B != "" ? $H[$B] : $H);
	}

	function
	is_view($R) {
		return $R["Engine"] == "view";
	}

	function
	fk_support($R) {
		global $h;
		return !$h->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");
	}

	function
	fields($Q) {
		global $h;
		$H = array();
		$pg = "";
		foreach (get_rows("PRAGMA table_info(" . table($Q) . ")") as $I) {
			$B = $I["name"];
			$T = strtolower($I["type"]);
			$Wb = $I["dflt_value"];
			$H[$B] = array("field" => $B, "type" => (preg_match('~int~i', $T) ? "integer" : (preg_match('~char|clob|text~i', $T) ? "text" : (preg_match('~blob~i', $T) ? "blob" : (preg_match('~real|floa|doub~i', $T) ? "real" : "numeric")))), "full_type" => $T, "default" => (preg_match("~'(.*)'~", $Wb, $A) ? str_replace("''", "'", $A[1]) : ($Wb == "NULL" ? null : $Wb)), "null" => !$I["notnull"], "privileges" => array("select" => 1, "insert" => 1, "update" => 1), "primary" => $I["pk"],);
			if ($I["pk"]) {
				if ($pg != "") $H[$pg]["auto_increment"] = false; elseif (preg_match('~^integer$~i', $T)) $H[$B]["auto_increment"] = true;
				$pg = $B;
			}
		}
		$Dh = $h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
		preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i', $Dh, $Ie, PREG_SET_ORDER);
		foreach ($Ie
				 as $A) {
			$B = str_replace('""', '"', preg_replace('~^"|"$~', '', $A[1]));
			if ($H[$B]) $H[$B]["collation"] = trim($A[3], "'");
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		global $h;
		if (!is_object($i)) $i = $h;
		$H = array();
		$Dh = $i->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
		if (preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i', $Dh, $A)) {
			$H[""] = array("type" => "PRIMARY", "columns" => array(), "lengths" => array(), "descs" => array());
			preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i', $A[1], $Ie, PREG_SET_ORDER);
			foreach ($Ie
					 as $A) {
				$H[""]["columns"][] = idf_unescape($A[2]) . $A[4];
				$H[""]["descs"][] = (preg_match('~DESC~i', $A[5]) ? '1' : null);
			}
		}
		if (!$H) {
			foreach (fields($Q) as $B => $o) {
				if ($o["primary"]) $H[""] = array("type" => "PRIMARY", "columns" => array($B), "lengths" => array(), "descs" => array(null));
			}
		}
		$Gh = get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = " . q($Q), $i);
		foreach (get_rows("PRAGMA index_list(" . table($Q) . ")", $i) as $I) {
			$B = $I["name"];
			$v = array("type" => ($I["unique"] ? "UNIQUE" : "INDEX"));
			$v["lengths"] = array();
			$v["descs"] = array();
			foreach (get_rows("PRAGMA index_info(" . idf_escape($B) . ")", $i) as $ch) {
				$v["columns"][] = $ch["name"];
				$v["descs"][] = null;
			}
			if (preg_match('~^CREATE( UNIQUE)? INDEX ' . preg_quote(idf_escape($B) . ' ON ' . idf_escape($Q), '~') . ' \((.*)\)$~i', $Gh[$B], $Mg)) {
				preg_match_all('/("[^"]*+")+( DESC)?/', $Mg[2], $Ie);
				foreach ($Ie[2] as $y => $X) {
					if ($X) $v["descs"][$y] = '1';
				}
			}
			if (!$H[""] || $v["type"] != "UNIQUE" || $v["columns"] != $H[""]["columns"] || $v["descs"] != $H[""]["descs"] || !preg_match("~^sqlite_~", $B)) $H[$B] = $v;
		}
		return $H;
	}

	function
	foreign_keys($Q) {
		$H = array();
		foreach (get_rows("PRAGMA foreign_key_list(" . table($Q) . ")") as $I) {
			$q =& $H[$I["id"]];
			if (!$q) $q = $I;
			$q["source"][] = $I["from"];
			$q["target"][] = $I["to"];
		}
		return $H;
	}

	function
	view($B) {
		global $h;
		return
			array("select" => preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU', '', $h->result("SELECT sql FROM sqlite_master WHERE name = " . q($B))));
	}

	function
	collations() {
		return (isset($_GET["create"]) ? get_vals("PRAGMA collation_list", 1) : array());
	}

	function
	information_schema($l) {
		return
			false;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	check_sqlite_name($B) {
		global $h;
		$Oc = "db|sdb|sqlite";
		if (!preg_match("~^[^\\0]*\\.($Oc)\$~", $B)) {
			$h->error = lang(23, str_replace("|", ", ", $Oc));
			return
				false;
		}
		return
			true;
	}

	function
	create_database($l, $d) {
		global $h;
		if (file_exists($l)) {
			$h->error = lang(24);
			return
				false;
		}
		if (!check_sqlite_name($l)) return
			false;
		try {
			$_ = new
			Min_SQLite($l);
		} catch (Exception$Ec) {
			$h->error = $Ec->getMessage();
			return
				false;
		}
		$_->query('PRAGMA encoding = "UTF-8"');
		$_->query('CREATE TABLE adminer (i)');
		$_->query('DROP TABLE adminer');
		return
			true;
	}

	function
	drop_databases($k) {
		global $h;
		$h->__construct(":memory:");
		foreach ($k
				 as $l) {
			if (!@unlink($l)) {
				$h->error = lang(24);
				return
					false;
			}
		}
		return
			true;
	}

	function
	rename_database($B, $d) {
		global $h;
		if (!check_sqlite_name($B)) return
			false;
		$h->__construct(":memory:");
		$h->error = lang(24);
		return @rename(DB, $B);
	}

	function
	auto_increment() {
		return " PRIMARY KEY" . (DRIVER == "sqlite" ? " AUTOINCREMENT" : "");
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		global $h;
		$Ti = ($Q == "" || $gd);
		foreach ($p
				 as $o) {
			if ($o[0] != "" || !$o[1] || $o[2]) {
				$Ti = true;
				break;
			}
		}
		$c = array();
		$Nf = array();
		foreach ($p
				 as $o) {
			if ($o[1]) {
				$c[] = ($Ti ? $o[1] : "ADD " . implode($o[1]));
				if ($o[0] != "") $Nf[$o[0]] = $o[1][0];
			}
		}
		if (!$Ti) {
			foreach ($c
					 as $X) {
				if (!queries("ALTER TABLE " . table($Q) . " $X")) return
					false;
			}
			if ($Q != $B && !queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($B))) return
				false;
		} elseif (!recreate_table($Q, $B, $c, $Nf, $gd, $Na)) return
			false;
		if ($Na) {
			queries("BEGIN");
			queries("UPDATE sqlite_sequence SET seq = $Na WHERE name = " . q($B));
			if (!$h->affected_rows) queries("INSERT INTO sqlite_sequence (name, seq) VALUES (" . q($B) . ", $Na)");
			queries("COMMIT");
		}
		return
			true;
	}

	function
	recreate_table($Q, $B, $p, $Nf, $gd, $Na, $w = array()) {
		global $h;
		if ($Q != "") {
			if (!$p) {
				foreach (fields($Q) as $y => $o) {
					if ($w) $o["auto_increment"] = 0;
					$p[] = process_field($o, $o);
					$Nf[$y] = idf_escape($y);
				}
			}
			$qg = false;
			foreach ($p
					 as $o) {
				if ($o[6]) $qg = true;
			}
			$lc = array();
			foreach ($w
					 as $y => $X) {
				if ($X[2] == "DROP") {
					$lc[$X[1]] = true;
					unset($w[$y]);
				}
			}
			foreach (indexes($Q) as $ke => $v) {
				$f = array();
				foreach ($v["columns"] as $y => $e) {
					if (!$Nf[$e]) continue
					2;
					$f[] = $Nf[$e] . ($v["descs"][$y] ? " DESC" : "");
				}
				if (!$lc[$ke]) {
					if ($v["type"] != "PRIMARY" || !$qg) $w[] = array($v["type"], $ke, $f);
				}
			}
			foreach ($w
					 as $y => $X) {
				if ($X[0] == "PRIMARY") {
					unset($w[$y]);
					$gd[] = "  PRIMARY KEY (" . implode(", ", $X[2]) . ")";
				}
			}
			foreach (foreign_keys($Q) as $ke => $q) {
				foreach ($q["source"] as $y => $e) {
					if (!$Nf[$e]) continue
					2;
					$q["source"][$y] = idf_unescape($Nf[$e]);
				}
				if (!isset($gd[" $ke"])) $gd[] = " " . format_foreign_key($q);
			}
			queries("BEGIN");
		}
		foreach ($p
				 as $y => $o) $p[$y] = "  " . implode($o);
		$p = array_merge($p, array_filter($gd));
		$ei = ($Q == $B ? "adminer_$B" : $B);
		if (!queries("CREATE TABLE " . table($ei) . " (\n" . implode(",\n", $p) . "\n)")) return
			false;
		if ($Q != "") {
			if ($Nf && !queries("INSERT INTO " . table($ei) . " (" . implode(", ", $Nf) . ") SELECT " . implode(", ", array_map('idf_escape', array_keys($Nf))) . " FROM " . table($Q))) return
				false;
			$Ei = array();
			foreach (triggers($Q) as $Ci => $li) {
				$Bi = trigger($Ci);
				$Ei[] = "CREATE TRIGGER " . idf_escape($Ci) . " " . implode(" ", $li) . " ON " . table($B) . "\n$Bi[Statement]";
			}
			$Na = $Na ? 0 : $h->result("SELECT seq FROM sqlite_sequence WHERE name = " . q($Q));
			if (!queries("DROP TABLE " . table($Q)) || ($Q == $B && !queries("ALTER TABLE " . table($ei) . " RENAME TO " . table($B))) || !alter_indexes($B, $w)) return
				false;
			if ($Na) queries("UPDATE sqlite_sequence SET seq = $Na WHERE name = " . q($B));
			foreach ($Ei
					 as $Bi) {
				if (!queries($Bi)) return
					false;
			}
			queries("COMMIT");
		}
		return
			true;
	}

	function
	index_sql($Q, $T, $B, $f) {
		return "CREATE $T " . ($T != "INDEX" ? "INDEX " : "") . idf_escape($B != "" ? $B : uniqid($Q . "_")) . " ON " . table($Q) . " $f";
	}

	function
	alter_indexes($Q, $c) {
		foreach ($c
				 as $pg) {
			if ($pg[0] == "PRIMARY") return
				recreate_table($Q, $Q, array(), array(), array(), 0, $c);
		}
		foreach (array_reverse($c) as $X) {
			if (!queries($X[2] == "DROP" ? "DROP INDEX " . idf_escape($X[1]) : index_sql($Q, $X[0], $X[1], "(" . implode(", ", $X[2]) . ")"))) return
				false;
		}
		return
			true;
	}

	function
	truncate_tables($S) {
		return
			apply_queries("DELETE FROM", $S);
	}

	function
	drop_views($fj) {
		return
			apply_queries("DROP VIEW", $fj);
	}

	function
	drop_tables($S) {
		return
			apply_queries("DROP TABLE", $S);
	}

	function
	move_tables($S, $fj, $ci) {
		return
			false;
	}

	function
	trigger($B) {
		global $h;
		if ($B == "") return
			array("Statement" => "BEGIN\n\t;\nEND");
		$u = '(?:[^`"\s]+|`[^`]*`|"[^"]*")+';
		$Di = trigger_options();
		preg_match("~^CREATE\\s+TRIGGER\\s*$u\\s*(" . implode("|", $Di["Timing"]) . ")\\s+([a-z]+)(?:\\s+OF\\s+($u))?\\s+ON\\s*$u\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is", $h->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = " . q($B)), $A);
		$of = $A[3];
		return
			array("Timing" => strtoupper($A[1]), "Event" => strtoupper($A[2]) . ($of ? " OF" : ""), "Of" => ($of[0] == '`' || $of[0] == '"' ? idf_unescape($of) : $of), "Trigger" => $B, "Statement" => $A[4],);
	}

	function
	triggers($Q) {
		$H = array();
		$Di = trigger_options();
		foreach (get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)) as $I) {
			preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*(' . implode("|", $Di["Timing"]) . ')\s*(.*?)\s+ON\b~i', $I["sql"], $A);
			$H[$I["name"]] = array($A[1], $A[2]);
		}
		return $H;
	}

	function
	trigger_options() {
		return
			array("Timing" => array("BEFORE", "AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "UPDATE OF", "DELETE"), "Type" => array("FOR EACH ROW"),);
	}

	function
	begin() {
		return
			queries("BEGIN");
	}

	function
	last_id() {
		global $h;
		return $h->result("SELECT LAST_INSERT_ROWID()");
	}

	function
	explain($h, $F) {
		return $h->query("EXPLAIN QUERY PLAN $F");
	}

	function
	found_rows($R, $Z) {
	}

	function
	types() {
		return
			array();
	}

	function
	schemas() {
		return
			array();
	}

	function
	get_schema() {
		return "";
	}

	function
	set_schema($gh) {
		return
			true;
	}

	function
	create_sql($Q, $Na, $Nh) {
		global $h;
		$H = $h->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = " . q($Q));
		foreach (indexes($Q) as $B => $v) {
			if ($B == '') continue;
			$H .= ";\n\n" . index_sql($Q, $v['type'], $B, "(" . implode(", ", array_map('idf_escape', $v['columns'])) . ")");
		}
		return $H;
	}

	function
	truncate_sql($Q) {
		return "DELETE FROM " . table($Q);
	}

	function
	use_sql($j) {
	}

	function
	trigger_sql($Q) {
		return
			implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)));
	}

	function
	show_variables() {
		global $h;
		$H = array();
		foreach (array("auto_vacuum", "cache_size", "count_changes", "default_cache_size", "empty_result_callbacks", "encoding", "foreign_keys", "full_column_names", "fullfsync", "journal_mode", "journal_size_limit", "legacy_file_format", "locking_mode", "page_size", "max_page_count", "read_uncommitted", "recursive_triggers", "reverse_unordered_selects", "secure_delete", "short_column_names", "synchronous", "temp_store", "temp_store_directory", "schema_version", "integrity_check", "quick_check") as $y) $H[$y] = $h->result("PRAGMA $y");
		return $H;
	}

	function
	show_status() {
		$H = array();
		foreach (get_vals("PRAGMA compile_options") as $Bf) {
			list($y, $X) = explode("=", $Bf, 2);
			$H[$y] = $X;
		}
		return $H;
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	support($Tc) {
		return
			preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~', $Tc);
	}

	$x = "sqlite";
	$U = array("integer" => 0, "real" => 0, "numeric" => 0, "text" => 0, "blob" => 0);
	$Mh = array_keys($U);
	$Ni = array();
	$_f = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL");
	$od = array("hex", "length", "lower", "round", "unixepoch", "upper");
	$ud = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
	$qc = array(array(), array("integer|real|numeric" => "+/-", "text" => "||",));
}
$ic["pgsql"] = "PostgreSQL";
if (isset($_GET["pgsql"])) {
	$mg = array("PgSQL", "PDO_PgSQL");
	define("DRIVER", "pgsql");
	if (extension_loaded("pgsql")) {
		class
		Min_DB {
			var $extension = "PgSQL", $_link, $_result, $_string, $_database = true, $server_info, $affected_rows, $error, $timeout;

			function
			_error($Ac, $n) {
				if (ini_bool("html_errors")) $n = html_entity_decode(strip_tags($n));
				$n = preg_replace('~^[^:]*: ~', '', $n);
				$this->error = $n;
			}

			function
			connect($M, $V, $E) {
				global $b;
				$l = $b->database();
				set_error_handler(array($this, '_error'));
				$this->_string = "host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' user='" . addcslashes($V, "'\\") . "' password='" . addcslashes($E, "'\\") . "'";
				$this->_link = @pg_connect("$this->_string dbname='" . ($l != "" ? addcslashes($l, "'\\") : "postgres") . "'", PGSQL_CONNECT_FORCE_NEW);
				if (!$this->_link && $l != "") {
					$this->_database = false;
					$this->_link = @pg_connect("$this->_string dbname='postgres'", PGSQL_CONNECT_FORCE_NEW);
				}
				restore_error_handler();
				if ($this->_link) {
					$dj = pg_version($this->_link);
					$this->server_info = $dj["server"];
					pg_set_client_encoding($this->_link, "UTF8");
				}
				return (bool)$this->_link;
			}

			function
			quote($P) {
				return "'" . pg_escape_string($this->_link, $P) . "'";
			}

			function
			value($X, $o) {
				return ($o["type"] == "bytea" ? pg_unescape_bytea($X) : $X);
			}

			function
			quoteBinary($P) {
				return "'" . pg_escape_bytea($this->_link, $P) . "'";
			}

			function
			select_db($j) {
				global $b;
				if ($j == $b->database()) return $this->_database;
				$H = @pg_connect("$this->_string dbname='" . addcslashes($j, "'\\") . "'", PGSQL_CONNECT_FORCE_NEW);
				if ($H) $this->_link = $H;
				return $H;
			}

			function
			close() {
				$this->_link = @pg_connect("$this->_string dbname='postgres'");
			}

			function
			query($F, $Hi = false) {
				$G = @pg_query($this->_link, $F);
				$this->error = "";
				if (!$G) {
					$this->error = pg_last_error($this->_link);
					$H = false;
				} elseif (!pg_num_fields($G)) {
					$this->affected_rows = pg_affected_rows($G);
					$H = true;
				} else$H = new
				Min_Result($G);
				if ($this->timeout) {
					$this->timeout = 0;
					$this->query("RESET statement_timeout");
				}
				return $H;
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					false;
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!$G || !$G->num_rows) return
					false;
				return
					pg_fetch_result($G->_result, 0, $o);
			}

			function
			warnings() {
				return
					h(pg_last_notice($this->_link));
			}
		}

		class
		Min_Result {
			var $_result, $_offset = 0, $num_rows;

			function
			__construct($G) {
				$this->_result = $G;
				$this->num_rows = pg_num_rows($G);
			}

			function
			fetch_assoc() {
				return
					pg_fetch_assoc($this->_result);
			}

			function
			fetch_row() {
				return
					pg_fetch_row($this->_result);
			}

			function
			fetch_field() {
				$e = $this->_offset++;
				$H = new
				stdClass;
				if (function_exists('pg_field_table')) $H->orgtable = pg_field_table($this->_result, $e);
				$H->name = pg_field_name($this->_result, $e);
				$H->orgname = $H->name;
				$H->type = pg_field_type($this->_result, $e);
				$H->charsetnr = ($H->type == "bytea" ? 63 : 0);
				return $H;
			}

			function
			__destruct() {
				pg_free_result($this->_result);
			}
		}
	} elseif (extension_loaded("pdo_pgsql")) {
		class
		Min_DB
			extends
			Min_PDO {
			var $extension = "PDO_PgSQL", $timeout;

			function
			connect($M, $V, $E) {
				global $b;
				$l = $b->database();
				$P = "pgsql:host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' options='-c client_encoding=utf8'";
				$this->dsn("$P dbname='" . ($l != "" ? addcslashes($l, "'\\") : "postgres") . "'", $V, $E);
				return
					true;
			}

			function
			select_db($j) {
				global $b;
				return ($b->database() == $j);
			}

			function
			quoteBinary($dh) {
				return
					q($dh);
			}

			function
			query($F, $Hi = false) {
				$H = parent::query($F, $Hi);
				if ($this->timeout) {
					$this->timeout = 0;
					parent::query("RESET statement_timeout");
				}
				return $H;
			}

			function
			warnings() {
				return '';
			}

			function
			close() {
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		insertUpdate($Q, $J, $pg) {
			global $h;
			foreach ($J
					 as $N) {
				$Oi = array();
				$Z = array();
				foreach ($N
						 as $y => $X) {
					$Oi[] = "$y = $X";
					if (isset($pg[idf_unescape($y)])) $Z[] = "$y = $X";
				}
				if (!(($Z && queries("UPDATE " . table($Q) . " SET " . implode(", ", $Oi) . " WHERE " . implode(" AND ", $Z)) && $h->affected_rows) || queries("INSERT INTO " . table($Q) . " (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ")"))) return
					false;
			}
			return
				true;
		}

		function
		slowQuery($F, $ki) {
			$this->_conn->query("SET statement_timeout = " . (1000 * $ki));
			$this->_conn->timeout = 1000 * $ki;
			return $F;
		}

		function
		convertSearch($u, $X, $o) {
			return (preg_match('~char|text' . (!preg_match('~LIKE~', $X["op"]) ? '|date|time(stamp)?|boolean|uuid|' . number_type() : '') . '~', $o["type"]) ? $u : "CAST($u AS text)");
		}

		function
		quoteBinary($dh) {
			return $this->_conn->quoteBinary($dh);
		}

		function
		warnings() {
			return $this->_conn->warnings();
		}

		function
		tableHelp($B) {
			$Ae = array("information_schema" => "infoschema", "pg_catalog" => "catalog",);
			$_ = $Ae[$_GET["ns"]];
			if ($_) return "$_-" . str_replace("_", "-", $B) . ".html";
		}
	}

	function
	idf_escape($u) {
		return '"' . str_replace('"', '""', $u) . '"';
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	connect() {
		global $b, $U, $Mh;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) {
			if (min_version(9, 0, $h)) {
				$h->query("SET application_name = 'Adminer'");
				if (min_version(9.2, 0, $h)) {
					$Mh[lang(25)][] = "json";
					$U["json"] = 4294967295;
					if (min_version(9.4, 0, $h)) {
						$Mh[lang(25)][] = "jsonb";
						$U["jsonb"] = 4294967295;
					}
				}
			}
			return $h;
		}
		return $h->error;
	}

	function
	get_databases() {
		return
			get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return " $F$Z" . ($z !== null ? $L . "LIMIT $z" . ($C ? " OFFSET $C" : "") : "");
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return (preg_match('~^INTO~', $F) ? limit($F, $Z, 1, 0, $L) : " $F" . (is_view(table_status1($Q)) ? $Z : " WHERE ctid = (SELECT ctid FROM " . table($Q) . $Z . $L . "LIMIT 1)"));
	}

	function
	db_collation($l, $qb) {
		global $h;
		return $h->result("SHOW LC_COLLATE");
	}

	function
	engines() {
		return
			array();
	}

	function
	logged_user() {
		global $h;
		return $h->result("SELECT user");
	}

	function
	tables_list() {
		$F = "SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";
		if (support('materializedview')) $F .= "
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";
		$F .= "
ORDER BY 1";
		return
			get_key_vals($F);
	}

	function
	count_tables($k) {
		return
			array();
	}

	function
	table_status($B = "") {
		$H = array();
		foreach (get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", " . (min_version(12) ? "''" : "CASE WHEN c.relhasoids THEN 'oid' ELSE '' END") . " AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f')
" . ($B != "" ? "AND relname = " . q($B) : "ORDER BY relname")) as $I) $H[$I["Name"]] = $I;
		return ($B != "" ? $H[$B] : $H);
	}

	function
	is_view($R) {
		return
			in_array($R["Engine"], array("view", "materialized view"));
	}

	function
	fk_support($R) {
		return
			true;
	}

	function
	fields($Q) {
		$H = array();
		$Da = array('timestamp without time zone' => 'timestamp', 'timestamp with time zone' => 'timestamptz',);
		$Hd = min_version(10) ? "(a.attidentity = 'd')::int" : '0';
		foreach (get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment, $Hd AS identity
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = " . q($Q) . "
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum") as $I) {
			preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~', $I["full_type"], $A);
			list(, $T, $ye, $I["length"], $xa, $Ga) = $A;
			$I["length"] .= $Ga;
			$fb = $T . $xa;
			if (isset($Da[$fb])) {
				$I["type"] = $Da[$fb];
				$I["full_type"] = $I["type"] . $ye . $Ga;
			} else {
				$I["type"] = $T;
				$I["full_type"] = $I["type"] . $ye . $xa . $Ga;
			}
			if ($I['identity']) $I['default'] = 'GENERATED BY DEFAULT AS IDENTITY';
			$I["null"] = !$I["attnotnull"];
			$I["auto_increment"] = $I['identity'] || preg_match('~^nextval\(~i', $I["default"]);
			$I["privileges"] = array("insert" => 1, "select" => 1, "update" => 1);
			if (preg_match('~(.+)::[^)]+(.*)~', $I["default"], $A)) $I["default"] = ($A[1] == "NULL" ? null : (($A[1][0] == "'" ? idf_unescape($A[1]) : $A[1]) . $A[2]));
			$H[$I["field"]] = $I;
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		global $h;
		if (!is_object($i)) $i = $h;
		$H = array();
		$Vh = $i->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($Q));
		$f = get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Vh AND attnum > 0", $i);
		foreach (get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption , (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Vh AND ci.oid = i.indexrelid", $i) as $I) {
			$Ng = $I["relname"];
			$H[$Ng]["type"] = ($I["indispartial"] ? "INDEX" : ($I["indisprimary"] ? "PRIMARY" : ($I["indisunique"] ? "UNIQUE" : "INDEX")));
			$H[$Ng]["columns"] = array();
			foreach (explode(" ", $I["indkey"]) as $Rd) $H[$Ng]["columns"][] = $f[$Rd];
			$H[$Ng]["descs"] = array();
			foreach (explode(" ", $I["indoption"]) as $Sd) $H[$Ng]["descs"][] = ($Sd & 1 ? '1' : null);
			$H[$Ng]["lengths"] = array();
		}
		return $H;
	}

	function
	foreign_keys($Q) {
		global $vf;
		$H = array();
		foreach (get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = " . q($Q) . " AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname") as $I) {
			if (preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA', $I['definition'], $A)) {
				$I['source'] = array_map('trim', explode(',', $A[1]));
				if (preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~', $A[2], $He)) {
					$I['ns'] = str_replace('""', '"', preg_replace('~^"(.+)"$~', '\1', $He[2]));
					$I['table'] = str_replace('""', '"', preg_replace('~^"(.+)"$~', '\1', $He[4]));
				}
				$I['target'] = array_map('trim', explode(',', $A[3]));
				$I['on_delete'] = (preg_match("~ON DELETE ($vf)~", $A[4], $He) ? $He[1] : 'NO ACTION');
				$I['on_update'] = (preg_match("~ON UPDATE ($vf)~", $A[4], $He) ? $He[1] : 'NO ACTION');
				$H[$I['conname']] = $I;
			}
		}
		return $H;
	}

	function
	view($B) {
		global $h;
		return
			array("select" => trim($h->result("SELECT pg_get_viewdef(" . $h->result("SELECT oid FROM pg_class WHERE relname = " . q($B)) . ")")));
	}

	function
	collations() {
		return
			array();
	}

	function
	information_schema($l) {
		return ($l == "information_schema");
	}

	function
	error() {
		global $h;
		$H = h($h->error);
		if (preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s', $H, $A)) $H = $A[1] . preg_replace('~((?:[^&]|&[^;]*;){' . strlen($A[3]) . '})(.*)~', '\1<b>\2</b>', $A[2]) . $A[4];
		return
			nl_br($H);
	}

	function
	create_database($l, $d) {
		return
			queries("CREATE DATABASE " . idf_escape($l) . ($d ? " ENCODING " . idf_escape($d) : ""));
	}

	function
	drop_databases($k) {
		global $h;
		$h->close();
		return
			apply_queries("DROP DATABASE", $k, 'idf_escape');
	}

	function
	rename_database($B, $d) {
		return
			queries("ALTER DATABASE " . idf_escape(DB) . " RENAME TO " . idf_escape($B));
	}

	function
	auto_increment() {
		return "";
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		$c = array();
		$_g = array();
		if ($Q != "" && $Q != $B) $_g[] = "ALTER TABLE " . table($Q) . " RENAME TO " . table($B);
		foreach ($p
				 as $o) {
			$e = idf_escape($o[0]);
			$X = $o[1];
			if (!$X) $c[] = "DROP $e"; else {
				$Zi = $X[5];
				unset($X[5]);
				if (isset($X[6]) && $o[0] == "") $X[1] = ($X[1] == "bigint" ? " big" : " ") . "serial";
				if ($o[0] == "") $c[] = ($Q != "" ? "ADD " : "  ") . implode($X); else {
					if ($e != $X[0]) $_g[] = "ALTER TABLE " . table($B) . " RENAME $e TO $X[0]";
					$c[] = "ALTER $e TYPE$X[1]";
					if (!$X[6]) {
						$c[] = "ALTER $e " . ($X[3] ? "SET$X[3]" : "DROP DEFAULT");
						$c[] = "ALTER $e " . ($X[2] == " NULL" ? "DROP NOT" : "SET") . $X[2];
					}
				}
				if ($o[0] != "" || $Zi != "") $_g[] = "COMMENT ON COLUMN " . table($B) . ".$X[0] IS " . ($Zi != "" ? substr($Zi, 9) : "''");
			}
		}
		$c = array_merge($c, $gd);
		if ($Q == "") array_unshift($_g, "CREATE TABLE " . table($B) . " (\n" . implode(",\n", $c) . "\n)"); elseif ($c) array_unshift($_g, "ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c));
		if ($Q != "" || $vb != "") $_g[] = "COMMENT ON TABLE " . table($B) . " IS " . q($vb);
		if ($Na != "") {
		}
		foreach ($_g
				 as $F) {
			if (!queries($F)) return
				false;
		}
		return
			true;
	}

	function
	alter_indexes($Q, $c) {
		$Hb = array();
		$jc = array();
		$_g = array();
		foreach ($c
				 as $X) {
			if ($X[0] != "INDEX") $Hb[] = ($X[2] == "DROP" ? "\nDROP CONSTRAINT " . idf_escape($X[1]) : "\nADD" . ($X[1] != "" ? " CONSTRAINT " . idf_escape($X[1]) : "") . " $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $X[2]) . ")"); elseif ($X[2] == "DROP") $jc[] = idf_escape($X[1]);
			else$_g[] = "CREATE INDEX " . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) . " (" . implode(", ", $X[2]) . ")";
		}
		if ($Hb) array_unshift($_g, "ALTER TABLE " . table($Q) . implode(",", $Hb));
		if ($jc) array_unshift($_g, "DROP INDEX " . implode(", ", $jc));
		foreach ($_g
				 as $F) {
			if (!queries($F)) return
				false;
		}
		return
			true;
	}

	function
	truncate_tables($S) {
		return
			queries("TRUNCATE " . implode(", ", array_map('table', $S)));
		return
			true;
	}

	function
	drop_views($fj) {
		return
			drop_tables($fj);
	}

	function
	drop_tables($S) {
		foreach ($S
				 as $Q) {
			$O = table_status($Q);
			if (!queries("DROP " . strtoupper($O["Engine"]) . " " . table($Q))) return
				false;
		}
		return
			true;
	}

	function
	move_tables($S, $fj, $ci) {
		foreach (array_merge($S, $fj) as $Q) {
			$O = table_status($Q);
			if (!queries("ALTER " . strtoupper($O["Engine"]) . " " . table($Q) . " SET SCHEMA " . idf_escape($ci))) return
				false;
		}
		return
			true;
	}

	function
	trigger($B, $Q = null) {
		if ($B == "") return
			array("Statement" => "EXECUTE PROCEDURE ()");
		if ($Q === null) $Q = $_GET['trigger'];
		$J = get_rows('SELECT t.trigger_name AS "Trigger", t.action_timing AS "Timing", (SELECT STRING_AGG(event_manipulation, \' OR \') FROM information_schema.triggers WHERE event_object_table = t.event_object_table AND trigger_name = t.trigger_name ) AS "Events", t.event_manipulation AS "Event", \'FOR EACH \' || t.action_orientation AS "Type", t.action_statement AS "Statement" FROM information_schema.triggers t WHERE t.event_object_table = ' . q($Q) . ' AND t.trigger_name = ' . q($B));
		return
			reset($J);
	}

	function
	triggers($Q) {
		$H = array();
		foreach (get_rows("SELECT * FROM information_schema.triggers WHERE event_object_table = " . q($Q)) as $I) $H[$I["trigger_name"]] = array($I["action_timing"], $I["event_manipulation"]);
		return $H;
	}

	function
	trigger_options() {
		return
			array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW", "FOR EACH STATEMENT"),);
	}

	function
	routine($B, $T) {
		$J = get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = ' . q($B));
		$H = $J[0];
		$H["returns"] = array("type" => $H["type_udt_name"]);
		$H["fields"] = get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = ' . q($B) . '
ORDER BY ordinal_position');
		return $H;
	}

	function
	routines() {
		return
			get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');
	}

	function
	routine_languages() {
		return
			get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");
	}

	function
	routine_id($B, $I) {
		$H = array();
		foreach ($I["fields"] as $o) $H[] = $o["type"];
		return
			idf_escape($B) . "(" . implode(", ", $H) . ")";
	}

	function
	last_id() {
		return
			0;
	}

	function
	explain($h, $F) {
		return $h->query("EXPLAIN $F");
	}

	function
	found_rows($R, $Z) {
		global $h;
		if (preg_match("~ rows=([0-9]+)~", $h->result("EXPLAIN SELECT * FROM " . idf_escape($R["Name"]) . ($Z ? " WHERE " . implode(" AND ", $Z) : "")), $Mg)) return $Mg[1];
		return
			false;
	}

	function
	types() {
		return
			get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");
	}

	function
	schemas() {
		return
			get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");
	}

	function
	get_schema() {
		global $h;
		return $h->result("SELECT current_schema()");
	}

	function
	set_schema($fh, $i = null) {
		global $h, $U, $Mh;
		if (!$i) $i = $h;
		$H = $i->query("SET search_path TO " . idf_escape($fh));
		foreach (types() as $T) {
			if (!isset($U[$T])) {
				$U[$T] = 0;
				$Mh[lang(26)][] = $T;
			}
		}
		return $H;
	}

	function
	create_sql($Q, $Na, $Nh) {
		global $h;
		$H = '';
		$Vg = array();
		$ph = array();
		$O = table_status($Q);
		if (is_view($O)) {
			$ej = view($Q);
			return
				rtrim("CREATE VIEW " . idf_escape($Q) . " AS $ej[select]", ";");
		}
		$p = fields($Q);
		$w = indexes($Q);
		ksort($w);
		$dd = foreign_keys($Q);
		ksort($dd);
		if (!$O || empty($p)) return
			false;
		$H = "CREATE TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " (\n    ";
		foreach ($p
				 as $Vc => $o) {
			$Wf = idf_escape($o['field']) . ' ' . $o['full_type'] . default_value($o) . ($o['attnotnull'] ? " NOT NULL" : "");
			$Vg[] = $Wf;
			if (preg_match('~nextval\(\'([^\']+)\'\)~', $o['default'], $Ie)) {
				$oh = $Ie[1];
				$Ch = reset(get_rows(min_version(10) ? "SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = " . q($oh) : "SELECT * FROM $oh"));
				$ph[] = ($Nh == "DROP+CREATE" ? "DROP SEQUENCE IF EXISTS $oh;\n" : "") . "CREATE SEQUENCE $oh INCREMENT $Ch[increment_by] MINVALUE $Ch[min_value] MAXVALUE $Ch[max_value] START " . ($Na ? $Ch['last_value'] : 1) . " CACHE $Ch[cache_value];";
			}
		}
		if (!empty($ph)) $H = implode("\n\n", $ph) . "\n\n$H";
		foreach ($w
				 as $Md => $v) {
			switch ($v['type']) {
				case'UNIQUE':
					$Vg[] = "CONSTRAINT " . idf_escape($Md) . " UNIQUE (" . implode(', ', array_map('idf_escape', $v['columns'])) . ")";
					break;
				case'PRIMARY':
					$Vg[] = "CONSTRAINT " . idf_escape($Md) . " PRIMARY KEY (" . implode(', ', array_map('idf_escape', $v['columns'])) . ")";
					break;
			}
		}
		foreach ($dd
				 as $cd => $bd) $Vg[] = "CONSTRAINT " . idf_escape($cd) . " $bd[definition] " . ($bd['deferrable'] ? 'DEFERRABLE' : 'NOT DEFERRABLE');
		$H .= implode(",\n    ", $Vg) . "\n) WITH (oids = " . ($O['Oid'] ? 'true' : 'false') . ");";
		foreach ($w
				 as $Md => $v) {
			if ($v['type'] == 'INDEX') {
				$f = array();
				foreach ($v['columns'] as $y => $X) $f[] = idf_escape($X) . ($v['descs'][$y] ? " DESC" : "");
				$H .= "\n\nCREATE INDEX " . idf_escape($Md) . " ON " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " USING btree (" . implode(', ', $f) . ");";
			}
		}
		if ($O['Comment']) $H .= "\n\nCOMMENT ON TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " IS " . q($O['Comment']) . ";";
		foreach ($p
				 as $Vc => $o) {
			if ($o['comment']) $H .= "\n\nCOMMENT ON COLUMN " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . "." . idf_escape($Vc) . " IS " . q($o['comment']) . ";";
		}
		return
			rtrim($H, ';');
	}

	function
	truncate_sql($Q) {
		return "TRUNCATE " . table($Q);
	}

	function
	trigger_sql($Q) {
		$O = table_status($Q);
		$H = "";
		foreach (triggers($Q) as $Ai => $_i) {
			$Bi = trigger($Ai, $O['Name']);
			$H .= "\nCREATE TRIGGER " . idf_escape($Bi['Trigger']) . " $Bi[Timing] $Bi[Events] ON " . idf_escape($O["nspname"]) . "." . idf_escape($O['Name']) . " $Bi[Type] $Bi[Statement];;\n";
		}
		return $H;
	}

	function
	use_sql($j) {
		return "\connect " . idf_escape($j);
	}

	function
	show_variables() {
		return
			get_key_vals("SHOW ALL");
	}

	function
	process_list() {
		return
			get_rows("SELECT * FROM pg_stat_activity ORDER BY " . (min_version(9.2) ? "pid" : "procpid"));
	}

	function
	show_status() {
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	support($Tc) {
		return
			preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|' . (min_version(9.3) ? 'materializedview|' : '') . 'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~', $Tc);
	}

	function
	kill_process($X) {
		return
			queries("SELECT pg_terminate_backend(" . number($X) . ")");
	}

	function
	connection_id() {
		return "SELECT pg_backend_pid()";
	}

	function
	max_connections() {
		global $h;
		return $h->result("SHOW max_connections");
	}

	$x = "pgsql";
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("smallint" => 5, "integer" => 10, "bigint" => 19, "boolean" => 1, "numeric" => 0, "real" => 7, "double precision" => 16, "money" => 20), lang(28) => array("date" => 13, "time" => 17, "timestamp" => 20, "timestamptz" => 21, "interval" => 0), lang(25) => array("character" => 0, "character varying" => 0, "text" => 0, "tsquery" => 0, "tsvector" => 0, "uuid" => 0, "xml" => 0), lang(29) => array("bit" => 0, "bit varying" => 0, "bytea" => 0), lang(30) => array("cidr" => 43, "inet" => 43, "macaddr" => 17, "txid_snapshot" => 0), lang(31) => array("box" => 0, "circle" => 0, "line" => 0, "lseg" => 0, "path" => 0, "point" => 0, "polygon" => 0),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
	$Ni = array();
	$_f = array("=", "<", ">", "<=", ">=", "!=", "~", "!~", "LIKE", "LIKE %%", "ILIKE", "ILIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL");
	$od = array("char_length", "lower", "round", "to_hex", "to_timestamp", "upper");
	$ud = array("avg", "count", "count distinct", "max", "min", "sum");
	$qc = array(array("char" => "md5", "date|time" => "now",), array(number_type() => "+/-", "date|time" => "+ interval/- interval", "char|text" => "||",));
}
$ic["oracle"] = "Oracle (beta)";
if (isset($_GET["oracle"])) {
	$mg = array("OCI8", "PDO_OCI");
	define("DRIVER", "oracle");
	if (extension_loaded("oci8")) {
		class
		Min_DB {
			var $extension = "oci8", $_link, $_result, $server_info, $affected_rows, $errno, $error;

			function
			_error($Ac, $n) {
				if (ini_bool("html_errors")) $n = html_entity_decode(strip_tags($n));
				$n = preg_replace('~^[^:]*: ~', '', $n);
				$this->error = $n;
			}

			function
			connect($M, $V, $E) {
				$this->_link = @oci_new_connect($V, $E, $M, "AL32UTF8");
				if ($this->_link) {
					$this->server_info = oci_server_version($this->_link);
					return
						true;
				}
				$n = oci_error();
				$this->error = $n["message"];
				return
					false;
			}

			function
			quote($P) {
				return "'" . str_replace("'", "''", $P) . "'";
			}

			function
			select_db($j) {
				return
					true;
			}

			function
			query($F, $Hi = false) {
				$G = oci_parse($this->_link, $F);
				$this->error = "";
				if (!$G) {
					$n = oci_error($this->_link);
					$this->errno = $n["code"];
					$this->error = $n["message"];
					return
						false;
				}
				set_error_handler(array($this, '_error'));
				$H = @oci_execute($G);
				restore_error_handler();
				if ($H) {
					if (oci_num_fields($G)) return
						new
						Min_Result($G);
					$this->affected_rows = oci_num_rows($G);
				}
				return $H;
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					false;
			}

			function
			result($F, $o = 1) {
				$G = $this->query($F);
				if (!is_object($G) || !oci_fetch($G->_result)) return
					false;
				return
					oci_result($G->_result, $o);
			}
		}

		class
		Min_Result {
			var $_result, $_offset = 1, $num_rows;

			function
			__construct($G) {
				$this->_result = $G;
			}

			function
			_convert($I) {
				foreach ((array)$I
						 as $y => $X) {
					if (is_a($X, 'OCI-Lob')) $I[$y] = $X->load();
				}
				return $I;
			}

			function
			fetch_assoc() {
				return $this->_convert(oci_fetch_assoc($this->_result));
			}

			function
			fetch_row() {
				return $this->_convert(oci_fetch_row($this->_result));
			}

			function
			fetch_field() {
				$e = $this->_offset++;
				$H = new
				stdClass;
				$H->name = oci_field_name($this->_result, $e);
				$H->orgname = $H->name;
				$H->type = oci_field_type($this->_result, $e);
				$H->charsetnr = (preg_match("~raw|blob|bfile~", $H->type) ? 63 : 0);
				return $H;
			}

			function
			__destruct() {
				oci_free_statement($this->_result);
			}
		}
	} elseif (extension_loaded("pdo_oci")) {
		class
		Min_DB
			extends
			Min_PDO {
			var $extension = "PDO_OCI";

			function
			connect($M, $V, $E) {
				$this->dsn("oci:dbname=//$M;charset=AL32UTF8", $V, $E);
				return
					true;
			}

			function
			select_db($j) {
				return
					true;
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		begin() {
			return
				true;
		}
	}

	function
	idf_escape($u) {
		return '"' . str_replace('"', '""', $u) . '"';
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) return $h;
		return $h->error;
	}

	function
	get_databases() {
		return
			get_vals("SELECT tablespace_name FROM user_tablespaces");
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return ($C ? " * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $F$Z) t WHERE rownum <= " . ($z + $C) . ") WHERE rnum > $C" : ($z !== null ? " * FROM (SELECT $F$Z) WHERE rownum <= " . ($z + $C) : " $F$Z"));
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return " $F$Z";
	}

	function
	db_collation($l, $qb) {
		global $h;
		return $h->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");
	}

	function
	engines() {
		return
			array();
	}

	function
	logged_user() {
		global $h;
		return $h->result("SELECT USER FROM DUAL");
	}

	function
	tables_list() {
		return
			get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = " . q(DB) . "
UNION SELECT view_name, 'view' FROM user_views
ORDER BY 1");
	}

	function
	count_tables($k) {
		return
			array();
	}

	function
	table_status($B = "") {
		$H = array();
		$hh = q($B);
		foreach (get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = ' . q(DB) . ($B != "" ? " AND table_name = $hh" : "") . "
UNION SELECT view_name, 'view', 0, 0 FROM user_views" . ($B != "" ? " WHERE view_name = $hh" : "") . "
ORDER BY 1") as $I) {
			if ($B != "") return $I;
			$H[$I["Name"]] = $I;
		}
		return $H;
	}

	function
	is_view($R) {
		return $R["Engine"] == "view";
	}

	function
	fk_support($R) {
		return
			true;
	}

	function
	fields($Q) {
		$H = array();
		foreach (get_rows("SELECT * FROM all_tab_columns WHERE table_name = " . q($Q) . " ORDER BY column_id") as $I) {
			$T = $I["DATA_TYPE"];
			$ye = "$I[DATA_PRECISION],$I[DATA_SCALE]";
			if ($ye == ",") $ye = $I["DATA_LENGTH"];
			$H[$I["COLUMN_NAME"]] = array("field" => $I["COLUMN_NAME"], "full_type" => $T . ($ye ? "($ye)" : ""), "type" => strtolower($T), "length" => $ye, "default" => $I["DATA_DEFAULT"], "null" => ($I["NULLABLE"] == "Y"), "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		$H = array();
		foreach (get_rows("SELECT uic.*, uc.constraint_type
FROM user_ind_columns uic
LEFT JOIN user_constraints uc ON uic.index_name = uc.constraint_name AND uic.table_name = uc.table_name
WHERE uic.table_name = " . q($Q) . "
ORDER BY uc.constraint_type, uic.column_position", $i) as $I) {
			$Md = $I["INDEX_NAME"];
			$H[$Md]["type"] = ($I["CONSTRAINT_TYPE"] == "P" ? "PRIMARY" : ($I["CONSTRAINT_TYPE"] == "U" ? "UNIQUE" : "INDEX"));
			$H[$Md]["columns"][] = $I["COLUMN_NAME"];
			$H[$Md]["lengths"][] = ($I["CHAR_LENGTH"] && $I["CHAR_LENGTH"] != $I["COLUMN_LENGTH"] ? $I["CHAR_LENGTH"] : null);
			$H[$Md]["descs"][] = ($I["DESCEND"] ? '1' : null);
		}
		return $H;
	}

	function
	view($B) {
		$J = get_rows('SELECT text "select" FROM user_views WHERE view_name = ' . q($B));
		return
			reset($J);
	}

	function
	collations() {
		return
			array();
	}

	function
	information_schema($l) {
		return
			false;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	explain($h, $F) {
		$h->query("EXPLAIN PLAN FOR $F");
		return $h->query("SELECT * FROM plan_table");
	}

	function
	found_rows($R, $Z) {
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		$c = $jc = array();
		foreach ($p
				 as $o) {
			$X = $o[1];
			if ($X && $o[0] != "" && idf_escape($o[0]) != $X[0]) queries("ALTER TABLE " . table($Q) . " RENAME COLUMN " . idf_escape($o[0]) . " TO $X[0]");
			if ($X) $c[] = ($Q != "" ? ($o[0] != "" ? "MODIFY (" : "ADD (") : "  ") . implode($X) . ($Q != "" ? ")" : ""); else$jc[] = idf_escape($o[0]);
		}
		if ($Q == "") return
			queries("CREATE TABLE " . table($B) . " (\n" . implode(",\n", $c) . "\n)");
		return (!$c || queries("ALTER TABLE " . table($Q) . "\n" . implode("\n", $c))) && (!$jc || queries("ALTER TABLE " . table($Q) . " DROP (" . implode(", ", $jc) . ")")) && ($Q == $B || queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($B)));
	}

	function
	foreign_keys($Q) {
		$H = array();
		$F = "SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = " . q($Q);
		foreach (get_rows($F) as $I) $H[$I['NAME']] = array("db" => $I['DEST_DB'], "table" => $I['DEST_TABLE'], "source" => array($I['SRC_COLUMN']), "target" => array($I['DEST_COLUMN']), "on_delete" => $I['ON_DELETE'], "on_update" => null,);
		return $H;
	}

	function
	truncate_tables($S) {
		return
			apply_queries("TRUNCATE TABLE", $S);
	}

	function
	drop_views($fj) {
		return
			apply_queries("DROP VIEW", $fj);
	}

	function
	drop_tables($S) {
		return
			apply_queries("DROP TABLE", $S);
	}

	function
	last_id() {
		return
			0;
	}

	function
	schemas() {
		return
			get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX'))");
	}

	function
	get_schema() {
		global $h;
		return $h->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");
	}

	function
	set_schema($gh, $i = null) {
		global $h;
		if (!$i) $i = $h;
		return $i->query("ALTER SESSION SET CURRENT_SCHEMA = " . idf_escape($gh));
	}

	function
	show_variables() {
		return
			get_key_vals('SELECT name, display_value FROM v$parameter');
	}

	function
	process_list() {
		return
			get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');
	}

	function
	show_status() {
		$J = get_rows('SELECT * FROM v$instance');
		return
			reset($J);
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	support($Tc) {
		return
			preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view|view_trigger)$~', $Tc);
	}

	$x = "oracle";
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("number" => 38, "binary_float" => 12, "binary_double" => 21), lang(28) => array("date" => 10, "timestamp" => 29, "interval year" => 12, "interval day" => 28), lang(25) => array("char" => 2000, "varchar2" => 4000, "nchar" => 2000, "nvarchar2" => 4000, "clob" => 4294967295, "nclob" => 4294967295), lang(29) => array("raw" => 2000, "long raw" => 2147483648, "blob" => 4294967295, "bfile" => 4294967296),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
	$Ni = array();
	$_f = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL");
	$od = array("length", "lower", "round", "upper");
	$ud = array("avg", "count", "count distinct", "max", "min", "sum");
	$qc = array(array("date" => "current_date", "timestamp" => "current_timestamp",), array("number|float|double" => "+/-", "date|timestamp" => "+ interval/- interval", "char|clob" => "||",));
}
$ic["mssql"] = "MS SQL (beta)";
if (isset($_GET["mssql"])) {
	$mg = array("SQLSRV", "MSSQL", "PDO_DBLIB");
	define("DRIVER", "mssql");
	if (extension_loaded("sqlsrv")) {
		class
		Min_DB {
			var $extension = "sqlsrv", $_link, $_result, $server_info, $affected_rows, $errno, $error;

			function
			_get_error() {
				$this->error = "";
				foreach (sqlsrv_errors() as $n) {
					$this->errno = $n["code"];
					$this->error .= "$n[message]\n";
				}
				$this->error = rtrim($this->error);
			}

			function
			connect($M, $V, $E) {
				global $b;
				$l = $b->database();
				$_b = array("UID" => $V, "PWD" => $E, "CharacterSet" => "UTF-8");
				if ($l != "") $_b["Database"] = $l;
				$this->_link = @sqlsrv_connect(preg_replace('~:~', ',', $M), $_b);
				if ($this->_link) {
					$Td = sqlsrv_server_info($this->_link);
					$this->server_info = $Td['SQLServerVersion'];
				} else$this->_get_error();
				return (bool)$this->_link;
			}

			function
			quote($P) {
				return "'" . str_replace("'", "''", $P) . "'";
			}

			function
			select_db($j) {
				return $this->query("USE " . idf_escape($j));
			}

			function
			query($F, $Hi = false) {
				$G = sqlsrv_query($this->_link, $F);
				$this->error = "";
				if (!$G) {
					$this->_get_error();
					return
						false;
				}
				return $this->store_result($G);
			}

			function
			multi_query($F) {
				$this->_result = sqlsrv_query($this->_link, $F);
				$this->error = "";
				if (!$this->_result) {
					$this->_get_error();
					return
						false;
				}
				return
					true;
			}

			function
			store_result($G = null) {
				if (!$G) $G = $this->_result;
				if (!$G) return
					false;
				if (sqlsrv_field_metadata($G)) return
					new
					Min_Result($G);
				$this->affected_rows = sqlsrv_rows_affected($G);
				return
					true;
			}

			function
			next_result() {
				return $this->_result ? sqlsrv_next_result($this->_result) : null;
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!is_object($G)) return
					false;
				$I = $G->fetch_row();
				return $I[$o];
			}
		}

		class
		Min_Result {
			var $_result, $_offset = 0, $_fields, $num_rows;

			function
			__construct($G) {
				$this->_result = $G;
			}

			function
			_convert($I) {
				foreach ((array)$I
						 as $y => $X) {
					if (is_a($X, 'DateTime')) $I[$y] = $X->format("Y-m-d H:i:s");
				}
				return $I;
			}

			function
			fetch_assoc() {
				return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_ASSOC));
			}

			function
			fetch_row() {
				return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_NUMERIC));
			}

			function
			fetch_field() {
				if (!$this->_fields) $this->_fields = sqlsrv_field_metadata($this->_result);
				$o = $this->_fields[$this->_offset++];
				$H = new
				stdClass;
				$H->name = $o["Name"];
				$H->orgname = $o["Name"];
				$H->type = ($o["Type"] == 1 ? 254 : 0);
				return $H;
			}

			function
			seek($C) {
				for ($s = 0; $s < $C; $s++) sqlsrv_fetch($this->_result);
			}

			function
			__destruct() {
				sqlsrv_free_stmt($this->_result);
			}
		}
	} elseif (extension_loaded("mssql")) {
		class
		Min_DB {
			var $extension = "MSSQL", $_link, $_result, $server_info, $affected_rows, $error;

			function
			connect($M, $V, $E) {
				$this->_link = @mssql_connect($M, $V, $E);
				if ($this->_link) {
					$G = $this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");
					if ($G) {
						$I = $G->fetch_row();
						$this->server_info = $this->result("sp_server_info 2", 2) . " [$I[0]] $I[1]";
					}
				} else$this->error = mssql_get_last_message();
				return (bool)$this->_link;
			}

			function
			quote($P) {
				return "'" . str_replace("'", "''", $P) . "'";
			}

			function
			select_db($j) {
				return
					mssql_select_db($j);
			}

			function
			query($F, $Hi = false) {
				$G = @mssql_query($F, $this->_link);
				$this->error = "";
				if (!$G) {
					$this->error = mssql_get_last_message();
					return
						false;
				}
				if ($G === true) {
					$this->affected_rows = mssql_rows_affected($this->_link);
					return
						true;
				}
				return
					new
					Min_Result($G);
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					mssql_next_result($this->_result->_result);
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!is_object($G)) return
					false;
				return
					mssql_result($G->_result, 0, $o);
			}
		}

		class
		Min_Result {
			var $_result, $_offset = 0, $_fields, $num_rows;

			function
			__construct($G) {
				$this->_result = $G;
				$this->num_rows = mssql_num_rows($G);
			}

			function
			fetch_assoc() {
				return
					mssql_fetch_assoc($this->_result);
			}

			function
			fetch_row() {
				return
					mssql_fetch_row($this->_result);
			}

			function
			num_rows() {
				return
					mssql_num_rows($this->_result);
			}

			function
			fetch_field() {
				$H = mssql_fetch_field($this->_result);
				$H->orgtable = $H->table;
				$H->orgname = $H->name;
				return $H;
			}

			function
			seek($C) {
				mssql_data_seek($this->_result, $C);
			}

			function
			__destruct() {
				mssql_free_result($this->_result);
			}
		}
	} elseif (extension_loaded("pdo_dblib")) {
		class
		Min_DB
			extends
			Min_PDO {
			var $extension = "PDO_DBLIB";

			function
			connect($M, $V, $E) {
				$this->dsn("dblib:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $E);
				return
					true;
			}

			function
			select_db($j) {
				return $this->query("USE " . idf_escape($j));
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		insertUpdate($Q, $J, $pg) {
			foreach ($J
					 as $N) {
				$Oi = array();
				$Z = array();
				foreach ($N
						 as $y => $X) {
					$Oi[] = "$y = $X";
					if (isset($pg[idf_unescape($y)])) $Z[] = "$y = $X";
				}
				if (!queries("MERGE " . table($Q) . " USING (VALUES(" . implode(", ", $N) . ")) AS source (c" . implode(", c", range(1, count($N))) . ") ON " . implode(" AND ", $Z) . " WHEN MATCHED THEN UPDATE SET " . implode(", ", $Oi) . " WHEN NOT MATCHED THEN INSERT (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ");")) return
					false;
			}
			return
				true;
		}

		function
		begin() {
			return
				queries("BEGIN TRANSACTION");
		}
	}

	function
	idf_escape($u) {
		return "[" . str_replace("]", "]]", $u) . "]";
	}

	function
	table($u) {
		return ($_GET["ns"] != "" ? idf_escape($_GET["ns"]) . "." : "") . idf_escape($u);
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) return $h;
		return $h->error;
	}

	function
	get_databases() {
		return
			get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return ($z !== null ? " TOP (" . ($z + $C) . ")" : "") . " $F$Z";
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return
			limit($F, $Z, 1, 0, $L);
	}

	function
	db_collation($l, $qb) {
		global $h;
		return $h->result("SELECT collation_name FROM sys.databases WHERE name = " . q($l));
	}

	function
	engines() {
		return
			array();
	}

	function
	logged_user() {
		global $h;
		return $h->result("SELECT SUSER_NAME()");
	}

	function
	tables_list() {
		return
			get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') ORDER BY name");
	}

	function
	count_tables($k) {
		global $h;
		$H = array();
		foreach ($k
				 as $l) {
			$h->select_db($l);
			$H[$l] = $h->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");
		}
		return $H;
	}

	function
	table_status($B = "") {
		$H = array();
		foreach (get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') " . ($B != "" ? "AND name = " . q($B) : "ORDER BY name")) as $I) {
			if ($B != "") return $I;
			$H[$I["Name"]] = $I;
		}
		return $H;
	}

	function
	is_view($R) {
		return $R["Engine"] == "VIEW";
	}

	function
	fk_support($R) {
		return
			true;
	}

	function
	fields($Q) {
		$xb = get_key_vals("SELECT objname, cast(value as varchar) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', " . q(get_schema()) . ", 'table', " . q($Q) . ", 'column', NULL)");
		$H = array();
		foreach (get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND o.type IN ('S', 'U', 'V') AND o.name = " . q($Q)) as $I) {
			$T = $I["type"];
			$ye = (preg_match("~char|binary~", $T) ? $I["max_length"] : ($T == "decimal" ? "$I[precision],$I[scale]" : ""));
			$H[$I["name"]] = array("field" => $I["name"], "full_type" => $T . ($ye ? "($ye)" : ""), "type" => $T, "length" => $ye, "default" => $I["default"], "null" => $I["is_nullable"], "auto_increment" => $I["is_identity"], "collation" => $I["collation_name"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1), "primary" => $I["is_identity"], "comment" => $xb[$I["name"]],);
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		$H = array();
		foreach (get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = " . q($Q), $i) as $I) {
			$B = $I["name"];
			$H[$B]["type"] = ($I["is_primary_key"] ? "PRIMARY" : ($I["is_unique"] ? "UNIQUE" : "INDEX"));
			$H[$B]["lengths"] = array();
			$H[$B]["columns"][$I["key_ordinal"]] = $I["column_name"];
			$H[$B]["descs"][$I["key_ordinal"]] = ($I["is_descending_key"] ? '1' : null);
		}
		return $H;
	}

	function
	view($B) {
		global $h;
		return
			array("select" => preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU', '', $h->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = " . q($B))));
	}

	function
	collations() {
		$H = array();
		foreach (get_vals("SELECT name FROM fn_helpcollations()") as $d) $H[preg_replace('~_.*~', '', $d)][] = $d;
		return $H;
	}

	function
	information_schema($l) {
		return
			false;
	}

	function
	error() {
		global $h;
		return
			nl_br(h(preg_replace('~^(\[[^]]*])+~m', '', $h->error)));
	}

	function
	create_database($l, $d) {
		return
			queries("CREATE DATABASE " . idf_escape($l) . (preg_match('~^[a-z0-9_]+$~i', $d) ? " COLLATE $d" : ""));
	}

	function
	drop_databases($k) {
		return
			queries("DROP DATABASE " . implode(", ", array_map('idf_escape', $k)));
	}

	function
	rename_database($B, $d) {
		if (preg_match('~^[a-z0-9_]+$~i', $d)) queries("ALTER DATABASE " . idf_escape(DB) . " COLLATE $d");
		queries("ALTER DATABASE " . idf_escape(DB) . " MODIFY NAME = " . idf_escape($B));
		return
			true;
	}

	function
	auto_increment() {
		return " IDENTITY" . ($_POST["Auto_increment"] != "" ? "(" . number($_POST["Auto_increment"]) . ",1)" : "") . " PRIMARY KEY";
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		$c = array();
		$xb = array();
		foreach ($p
				 as $o) {
			$e = idf_escape($o[0]);
			$X = $o[1];
			if (!$X) $c["DROP"][] = " COLUMN $e"; else {
				$X[1] = preg_replace("~( COLLATE )'(\\w+)'~", '\1\2', $X[1]);
				$xb[$o[0]] = $X[5];
				unset($X[5]);
				if ($o[0] == "") $c["ADD"][] = "\n  " . implode("", $X) . ($Q == "" ? substr($gd[$X[0]], 16 + strlen($X[0])) : ""); else {
					unset($X[6]);
					if ($e != $X[0]) queries("EXEC sp_rename " . q(table($Q) . ".$e") . ", " . q(idf_unescape($X[0])) . ", 'COLUMN'");
					$c["ALTER COLUMN " . implode("", $X)][] = "";
				}
			}
		}
		if ($Q == "") return
			queries("CREATE TABLE " . table($B) . " (" . implode(",", (array)$c["ADD"]) . "\n)");
		if ($Q != $B) queries("EXEC sp_rename " . q(table($Q)) . ", " . q($B));
		if ($gd) $c[""] = $gd;
		foreach ($c
				 as $y => $X) {
			if (!queries("ALTER TABLE " . idf_escape($B) . " $y" . implode(",", $X))) return
				false;
		}
		foreach ($xb
				 as $y => $X) {
			$vb = substr($X, 9);
			queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table',  @level1name = " . q($B) . ", @level2type = N'Column', @level2name = " . q($y));
			queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = " . $vb . ", @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table',  @level1name = " . q($B) . ", @level2type = N'Column', @level2name = " . q($y));
		}
		return
			true;
	}

	function
	alter_indexes($Q, $c) {
		$v = array();
		$jc = array();
		foreach ($c
				 as $X) {
			if ($X[2] == "DROP") {
				if ($X[0] == "PRIMARY") $jc[] = idf_escape($X[1]); else$v[] = idf_escape($X[1]) . " ON " . table($Q);
			} elseif (!queries(($X[0] != "PRIMARY" ? "CREATE $X[0] " . ($X[0] != "INDEX" ? "INDEX " : "") . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) : "ALTER TABLE " . table($Q) . " ADD PRIMARY KEY") . " (" . implode(", ", $X[2]) . ")")) return
				false;
		}
		return (!$v || queries("DROP INDEX " . implode(", ", $v))) && (!$jc || queries("ALTER TABLE " . table($Q) . " DROP " . implode(", ", $jc)));
	}

	function
	last_id() {
		global $h;
		return $h->result("SELECT SCOPE_IDENTITY()");
	}

	function
	explain($h, $F) {
		$h->query("SET SHOWPLAN_ALL ON");
		$H = $h->query($F);
		$h->query("SET SHOWPLAN_ALL OFF");
		return $H;
	}

	function
	found_rows($R, $Z) {
	}

	function
	foreign_keys($Q) {
		$H = array();
		foreach (get_rows("EXEC sp_fkeys @fktable_name = " . q($Q)) as $I) {
			$q =& $H[$I["FK_NAME"]];
			$q["db"] = $I["PKTABLE_QUALIFIER"];
			$q["table"] = $I["PKTABLE_NAME"];
			$q["source"][] = $I["FKCOLUMN_NAME"];
			$q["target"][] = $I["PKCOLUMN_NAME"];
		}
		return $H;
	}

	function
	truncate_tables($S) {
		return
			apply_queries("TRUNCATE TABLE", $S);
	}

	function
	drop_views($fj) {
		return
			queries("DROP VIEW " . implode(", ", array_map('table', $fj)));
	}

	function
	drop_tables($S) {
		return
			queries("DROP TABLE " . implode(", ", array_map('table', $S)));
	}

	function
	move_tables($S, $fj, $ci) {
		return
			apply_queries("ALTER SCHEMA " . idf_escape($ci) . " TRANSFER", array_merge($S, $fj));
	}

	function
	trigger($B) {
		if ($B == "") return
			array();
		$J = get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = " . q($B));
		$H = reset($J);
		if ($H) $H["Statement"] = preg_replace('~^.+\s+AS\s+~isU', '', $H["text"]);
		return $H;
	}

	function
	triggers($Q) {
		$H = array();
		foreach (get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = " . q($Q)) as $I) $H[$I["name"]] = array($I["Timing"], $I["Event"]);
		return $H;
	}

	function
	trigger_options() {
		return
			array("Timing" => array("AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("AS"),);
	}

	function
	schemas() {
		return
			get_vals("SELECT name FROM sys.schemas");
	}

	function
	get_schema() {
		global $h;
		if ($_GET["ns"] != "") return $_GET["ns"];
		return $h->result("SELECT SCHEMA_NAME()");
	}

	function
	set_schema($fh) {
		return
			true;
	}

	function
	use_sql($j) {
		return "USE " . idf_escape($j);
	}

	function
	show_variables() {
		return
			array();
	}

	function
	show_status() {
		return
			array();
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	support($Tc) {
		return
			preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~', $Tc);
	}

	$x = "mssql";
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("tinyint" => 3, "smallint" => 5, "int" => 10, "bigint" => 20, "bit" => 1, "decimal" => 0, "real" => 12, "float" => 53, "smallmoney" => 10, "money" => 20), lang(28) => array("date" => 10, "smalldatetime" => 19, "datetime" => 19, "datetime2" => 19, "time" => 8, "datetimeoffset" => 10), lang(25) => array("char" => 8000, "varchar" => 8000, "text" => 2147483647, "nchar" => 4000, "nvarchar" => 4000, "ntext" => 1073741823), lang(29) => array("binary" => 8000, "varbinary" => 8000, "image" => 2147483647),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
	$Ni = array();
	$_f = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL");
	$od = array("len", "lower", "round", "upper");
	$ud = array("avg", "count", "count distinct", "max", "min", "sum");
	$qc = array(array("date|time" => "getdate",), array("int|decimal|real|float|money|datetime" => "+/-", "char|text" => "+",));
}
$ic['firebird'] = 'Firebird (alpha)';
if (isset($_GET["firebird"])) {
	$mg = array("interbase");
	define("DRIVER", "firebird");
	if (extension_loaded("interbase")) {
		class
		Min_DB {
			var $extension = "Firebird", $server_info, $affected_rows, $errno, $error, $_link, $_result;

			function
			connect($M, $V, $E) {
				$this->_link = ibase_connect($M, $V, $E);
				if ($this->_link) {
					$Ri = explode(':', $M);
					$this->service_link = ibase_service_attach($Ri[0], $V, $E);
					$this->server_info = ibase_server_info($this->service_link, IBASE_SVC_SERVER_VERSION);
				} else {
					$this->errno = ibase_errcode();
					$this->error = ibase_errmsg();
				}
				return (bool)$this->_link;
			}

			function
			quote($P) {
				return "'" . str_replace("'", "''", $P) . "'";
			}

			function
			select_db($j) {
				return ($j == "domain");
			}

			function
			query($F, $Hi = false) {
				$G = ibase_query($F, $this->_link);
				if (!$G) {
					$this->errno = ibase_errcode();
					$this->error = ibase_errmsg();
					return
						false;
				}
				$this->error = "";
				if ($G === true) {
					$this->affected_rows = ibase_affected_rows($this->_link);
					return
						true;
				}
				return
					new
					Min_Result($G);
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					false;
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!$G || !$G->num_rows) return
					false;
				$I = $G->fetch_row();
				return $I[$o];
			}
		}

		class
		Min_Result {
			var $num_rows, $_result, $_offset = 0;

			function
			__construct($G) {
				$this->_result = $G;
			}

			function
			fetch_assoc() {
				return
					ibase_fetch_assoc($this->_result);
			}

			function
			fetch_row() {
				return
					ibase_fetch_row($this->_result);
			}

			function
			fetch_field() {
				$o = ibase_field_info($this->_result, $this->_offset++);
				return (object)array('name' => $o['name'], 'orgname' => $o['name'], 'type' => $o['type'], 'charsetnr' => $o['length'],);
			}

			function
			__destruct() {
				ibase_free_result($this->_result);
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
	}

	function
	idf_escape($u) {
		return '"' . str_replace('"', '""', $u) . '"';
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) return $h;
		return $h->error;
	}

	function
	get_databases($ed) {
		return
			array("domain");
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		$H = '';
		$H .= ($z !== null ? $L . "FIRST $z" . ($C ? " SKIP $C" : "") : "");
		$H .= " $F$Z";
		return $H;
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return
			limit($F, $Z, 1, 0, $L);
	}

	function
	db_collation($l, $qb) {
	}

	function
	engines() {
		return
			array();
	}

	function
	logged_user() {
		global $b;
		$Kb = $b->credentials();
		return $Kb[1];
	}

	function
	tables_list() {
		global $h;
		$F = 'SELECT RDB$RELATION_NAME FROM rdb$relations WHERE rdb$system_flag = 0';
		$G = ibase_query($h->_link, $F);
		$H = array();
		while ($I = ibase_fetch_assoc($G)) $H[$I['RDB$RELATION_NAME']] = 'table';
		ksort($H);
		return $H;
	}

	function
	count_tables($k) {
		return
			array();
	}

	function
	table_status($B = "", $Sc = false) {
		global $h;
		$H = array();
		$Pb = tables_list();
		foreach ($Pb
				 as $v => $X) {
			$v = trim($v);
			$H[$v] = array('Name' => $v, 'Engine' => 'standard',);
			if ($B == $v) return $H[$v];
		}
		return $H;
	}

	function
	is_view($R) {
		return
			false;
	}

	function
	fk_support($R) {
		return
			preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]);
	}

	function
	fields($Q) {
		global $h;
		$H = array();
		$F = 'SELECT r.RDB$FIELD_NAME AS field_name,
r.RDB$DESCRIPTION AS field_description,
r.RDB$DEFAULT_VALUE AS field_default_value,
r.RDB$NULL_FLAG AS field_not_null_constraint,
f.RDB$FIELD_LENGTH AS field_length,
f.RDB$FIELD_PRECISION AS field_precision,
f.RDB$FIELD_SCALE AS field_scale,
CASE f.RDB$FIELD_TYPE
WHEN 261 THEN \'BLOB\'
WHEN 14 THEN \'CHAR\'
WHEN 40 THEN \'CSTRING\'
WHEN 11 THEN \'D_FLOAT\'
WHEN 27 THEN \'DOUBLE\'
WHEN 10 THEN \'FLOAT\'
WHEN 16 THEN \'INT64\'
WHEN 8 THEN \'INTEGER\'
WHEN 9 THEN \'QUAD\'
WHEN 7 THEN \'SMALLINT\'
WHEN 12 THEN \'DATE\'
WHEN 13 THEN \'TIME\'
WHEN 35 THEN \'TIMESTAMP\'
WHEN 37 THEN \'VARCHAR\'
ELSE \'UNKNOWN\'
END AS field_type,
f.RDB$FIELD_SUB_TYPE AS field_subtype,
coll.RDB$COLLATION_NAME AS field_collation,
cset.RDB$CHARACTER_SET_NAME AS field_charset
FROM RDB$RELATION_FIELDS r
LEFT JOIN RDB$FIELDS f ON r.RDB$FIELD_SOURCE = f.RDB$FIELD_NAME
LEFT JOIN RDB$COLLATIONS coll ON f.RDB$COLLATION_ID = coll.RDB$COLLATION_ID
LEFT JOIN RDB$CHARACTER_SETS cset ON f.RDB$CHARACTER_SET_ID = cset.RDB$CHARACTER_SET_ID
WHERE r.RDB$RELATION_NAME = ' . q($Q) . '
ORDER BY r.RDB$FIELD_POSITION';
		$G = ibase_query($h->_link, $F);
		while ($I = ibase_fetch_assoc($G)) $H[trim($I['FIELD_NAME'])] = array("field" => trim($I["FIELD_NAME"]), "full_type" => trim($I["FIELD_TYPE"]), "type" => trim($I["FIELD_SUB_TYPE"]), "default" => trim($I['FIELD_DEFAULT_VALUE']), "null" => (trim($I["FIELD_NOT_NULL_CONSTRAINT"]) == "YES"), "auto_increment" => '0', "collation" => trim($I["FIELD_COLLATION"]), "privileges" => array("insert" => 1, "select" => 1, "update" => 1), "comment" => trim($I["FIELD_DESCRIPTION"]),);
		return $H;
	}

	function
	indexes($Q, $i = null) {
		$H = array();
		return $H;
	}

	function
	foreign_keys($Q) {
		return
			array();
	}

	function
	collations() {
		return
			array();
	}

	function
	information_schema($l) {
		return
			false;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	types() {
		return
			array();
	}

	function
	schemas() {
		return
			array();
	}

	function
	get_schema() {
		return "";
	}

	function
	set_schema($fh) {
		return
			true;
	}

	function
	support($Tc) {
		return
			preg_match("~^(columns|sql|status|table)$~", $Tc);
	}

	$x = "firebird";
	$_f = array("=");
	$od = array();
	$ud = array();
	$qc = array();
}
$ic["simpledb"] = "SimpleDB";
if (isset($_GET["simpledb"])) {
	$mg = array("SimpleXML + allow_url_fopen");
	define("DRIVER", "simpledb");
	if (class_exists('SimpleXMLElement') && ini_bool('allow_url_fopen')) {
		class
		Min_DB {
			var $extension = "SimpleXML", $server_info = '2009-04-15', $error, $timeout, $next, $affected_rows, $_result;

			function
			select_db($j) {
				return ($j == "domain");
			}

			function
			query($F, $Hi = false) {
				$Tf = array('SelectExpression' => $F, 'ConsistentRead' => 'true');
				if ($this->next) $Tf['NextToken'] = $this->next;
				$G = sdb_request_all('Select', 'Item', $Tf, $this->timeout);
				$this->timeout = 0;
				if ($G === false) return $G;
				if (preg_match('~^\s*SELECT\s+COUNT\(~i', $F)) {
					$Qh = 0;
					foreach ($G
							 as $fe) $Qh += $fe->Attribute->Value;
					$G = array((object)array('Attribute' => array((object)array('Name' => 'Count', 'Value' => $Qh,))));
				}
				return
					new
					Min_Result($G);
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					false;
			}

			function
			quote($P) {
				return "'" . str_replace("'", "''", $P) . "'";
			}
		}

		class
		Min_Result {
			var $num_rows, $_rows = array(), $_offset = 0;

			function
			__construct($G) {
				foreach ($G
						 as $fe) {
					$I = array();
					if ($fe->Name != '') $I['itemName()'] = (string)$fe->Name;
					foreach ($fe->Attribute
							 as $Ja) {
						$B = $this->_processValue($Ja->Name);
						$Y = $this->_processValue($Ja->Value);
						if (isset($I[$B])) {
							$I[$B] = (array)$I[$B];
							$I[$B][] = $Y;
						} else$I[$B] = $Y;
					}
					$this->_rows[] = $I;
					foreach ($I
							 as $y => $X) {
						if (!isset($this->_rows[0][$y])) $this->_rows[0][$y] = null;
					}
				}
				$this->num_rows = count($this->_rows);
			}

			function
			_processValue($tc) {
				return (is_object($tc) && $tc['encoding'] == 'base64' ? base64_decode($tc) : (string)$tc);
			}

			function
			fetch_assoc() {
				$I = current($this->_rows);
				if (!$I) return $I;
				$H = array();
				foreach ($this->_rows[0] as $y => $X) $H[$y] = $I[$y];
				next($this->_rows);
				return $H;
			}

			function
			fetch_row() {
				$H = $this->fetch_assoc();
				if (!$H) return $H;
				return
					array_values($H);
			}

			function
			fetch_field() {
				$le = array_keys($this->_rows[0]);
				return (object)array('name' => $le[$this->_offset++]);
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		public $pg = "itemName()";

		function
		_chunkRequest($Id, $wa, $Tf, $Ic = array()) {
			global $h;
			foreach (array_chunk($Id, 25) as $jb) {
				$Uf = $Tf;
				foreach ($jb
						 as $s => $t) {
					$Uf["Item.$s.ItemName"] = $t;
					foreach ($Ic
							 as $y => $X) $Uf["Item.$s.$y"] = $X;
				}
				if (!sdb_request($wa, $Uf)) return
					false;
			}
			$h->affected_rows = count($Id);
			return
				true;
		}

		function
		_extractIds($Q, $Ag, $z) {
			$H = array();
			if (preg_match_all("~itemName\(\) = (('[^']*+')+)~", $Ag, $Ie)) $H = array_map('idf_unescape', $Ie[1]); else {
				foreach (sdb_request_all('Select', 'Item', array('SelectExpression' => 'SELECT itemName() FROM ' . table($Q) . $Ag . ($z ? " LIMIT 1" : ""))) as $fe) $H[] = $fe->Name;
			}
			return $H;
		}

		function
		select($Q, $K, $Z, $rd, $Ef = array(), $z = 1, $D = 0, $rg = false) {
			global $h;
			$h->next = $_GET["next"];
			$H = parent::select($Q, $K, $Z, $rd, $Ef, $z, $D, $rg);
			$h->next = 0;
			return $H;
		}

		function
		delete($Q, $Ag, $z = 0) {
			return $this->_chunkRequest($this->_extractIds($Q, $Ag, $z), 'BatchDeleteAttributes', array('DomainName' => $Q));
		}

		function
		update($Q, $N, $Ag, $z = 0, $L = "\n") {
			$Zb = array();
			$Xd = array();
			$s = 0;
			$Id = $this->_extractIds($Q, $Ag, $z);
			$t = idf_unescape($N["`itemName()`"]);
			unset($N["`itemName()`"]);
			foreach ($N
					 as $y => $X) {
				$y = idf_unescape($y);
				if ($X == "NULL" || ($t != "" && array($t) != $Id)) $Zb["Attribute." . count($Zb) . ".Name"] = $y;
				if ($X != "NULL") {
					foreach ((array)$X
							 as $he => $W) {
						$Xd["Attribute.$s.Name"] = $y;
						$Xd["Attribute.$s.Value"] = (is_array($X) ? $W : idf_unescape($W));
						if (!$he) $Xd["Attribute.$s.Replace"] = "true";
						$s++;
					}
				}
			}
			$Tf = array('DomainName' => $Q);
			return (!$Xd || $this->_chunkRequest(($t != "" ? array($t) : $Id), 'BatchPutAttributes', $Tf, $Xd)) && (!$Zb || $this->_chunkRequest($Id, 'BatchDeleteAttributes', $Tf, $Zb));
		}

		function
		insert($Q, $N) {
			$Tf = array("DomainName" => $Q);
			$s = 0;
			foreach ($N
					 as $B => $Y) {
				if ($Y != "NULL") {
					$B = idf_unescape($B);
					if ($B == "itemName()") $Tf["ItemName"] = idf_unescape($Y); else {
						foreach ((array)$Y
								 as $X) {
							$Tf["Attribute.$s.Name"] = $B;
							$Tf["Attribute.$s.Value"] = (is_array($Y) ? $X : idf_unescape($Y));
							$s++;
						}
					}
				}
			}
			return
				sdb_request('PutAttributes', $Tf);
		}

		function
		insertUpdate($Q, $J, $pg) {
			foreach ($J
					 as $N) {
				if (!$this->update($Q, $N, "WHERE `itemName()` = " . q($N["`itemName()`"]))) return
					false;
			}
			return
				true;
		}

		function
		begin() {
			return
				false;
		}

		function
		commit() {
			return
				false;
		}

		function
		rollback() {
			return
				false;
		}

		function
		slowQuery($F, $ki) {
			$this->_conn->timeout = $ki;
			return $F;
		}
	}

	function
	connect() {
		global $b;
		list(, , $E) = $b->credentials();
		if ($E != "") return
			lang(22);
		return
			new
			Min_DB;
	}

	function
	support($Tc) {
		return
			preg_match('~sql~', $Tc);
	}

	function
	logged_user() {
		global $b;
		$Kb = $b->credentials();
		return $Kb[1];
	}

	function
	get_databases() {
		return
			array("domain");
	}

	function
	collations() {
		return
			array();
	}

	function
	db_collation($l, $qb) {
	}

	function
	tables_list() {
		global $h;
		$H = array();
		foreach (sdb_request_all('ListDomains', 'DomainName') as $Q) $H[(string)$Q] = 'table';
		if ($h->error && defined("PAGE_HEADER")) echo "<p class='error'>" . error() . "\n";
		return $H;
	}

	function
	table_status($B = "", $Sc = false) {
		$H = array();
		foreach (($B != "" ? array($B => true) : tables_list()) as $Q => $T) {
			$I = array("Name" => $Q, "Auto_increment" => "");
			if (!$Sc) {
				$Ve = sdb_request('DomainMetadata', array('DomainName' => $Q));
				if ($Ve) {
					foreach (array("Rows" => "ItemCount", "Data_length" => "ItemNamesSizeBytes", "Index_length" => "AttributeValuesSizeBytes", "Data_free" => "AttributeNamesSizeBytes",) as $y => $X) $I[$y] = (string)$Ve->$X;
				}
			}
			if ($B != "") return $I;
			$H[$Q] = $I;
		}
		return $H;
	}

	function
	explain($h, $F) {
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	information_schema() {
	}

	function
	is_view($R) {
	}

	function
	indexes($Q, $i = null) {
		return
			array(array("type" => "PRIMARY", "columns" => array("itemName()")),);
	}

	function
	fields($Q) {
		return
			fields_from_edit();
	}

	function
	foreign_keys($Q) {
		return
			array();
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	idf_escape($u) {
		return "`" . str_replace("`", "``", $u) . "`";
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return " $F$Z" . ($z !== null ? $L . "LIMIT $z" : "");
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	fk_support($R) {
	}

	function
	engines() {
		return
			array();
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		return ($Q == "" && sdb_request('CreateDomain', array('DomainName' => $B)));
	}

	function
	drop_tables($S) {
		foreach ($S
				 as $Q) {
			if (!sdb_request('DeleteDomain', array('DomainName' => $Q))) return
				false;
		}
		return
			true;
	}

	function
	count_tables($k) {
		foreach ($k
				 as $l) return
			array($l => count(tables_list()));
	}

	function
	found_rows($R, $Z) {
		return ($Z ? null : $R["Rows"]);
	}

	function
	last_id() {
	}

	function
	hmac($Ca, $Pb, $y, $Eg = false) {
		$Wa = 64;
		if (strlen($y) > $Wa) $y = pack("H*", $Ca($y));
		$y = str_pad($y, $Wa, "\0");
		$ie = $y ^ str_repeat("\x36", $Wa);
		$je = $y ^ str_repeat("\x5C", $Wa);
		$H = $Ca($je . pack("H*", $Ca($ie . $Pb)));
		if ($Eg) $H = pack("H*", $H);
		return $H;
	}

	function
	sdb_request($wa, $Tf = array()) {
		global $b, $h;
		list($Ed, $Tf['AWSAccessKeyId'], $ih) = $b->credentials();
		$Tf['Action'] = $wa;
		$Tf['Timestamp'] = gmdate('Y-m-d\TH:i:s+00:00');
		$Tf['Version'] = '2009-04-15';
		$Tf['SignatureVersion'] = 2;
		$Tf['SignatureMethod'] = 'HmacSHA1';
		ksort($Tf);
		$F = '';
		foreach ($Tf
				 as $y => $X) $F .= '&' . rawurlencode($y) . '=' . rawurlencode($X);
		$F = str_replace('%7E', '~', substr($F, 1));
		$F .= "&Signature=" . urlencode(base64_encode(hmac('sha1', "POST\n" . preg_replace('~^https?://~', '', $Ed) . "\n/\n$F", $ih, true)));
		@ini_set('track_errors', 1);
		$Xc = @file_get_contents((preg_match('~^https?://~', $Ed) ? $Ed : "http://$Ed"), false, stream_context_create(array('http' => array('method' => 'POST', 'content' => $F, 'ignore_errors' => 1,))));
		if (!$Xc) {
			$h->error = $php_errormsg;
			return
				false;
		}
		libxml_use_internal_errors(true);
		$sj = simplexml_load_string($Xc);
		if (!$sj) {
			$n = libxml_get_last_error();
			$h->error = $n->message;
			return
				false;
		}
		if ($sj->Errors) {
			$n = $sj->Errors->Error;
			$h->error = "$n->Message ($n->Code)";
			return
				false;
		}
		$h->error = '';
		$bi = $wa . "Result";
		return ($sj->$bi ? $sj->$bi : true);
	}

	function
	sdb_request_all($wa, $bi, $Tf = array(), $ki = 0) {
		$H = array();
		$Ih = ($ki ? microtime(true) : 0);
		$z = (preg_match('~LIMIT\s+(\d+)\s*$~i', $Tf['SelectExpression'], $A) ? $A[1] : 0);
		do {
			$sj = sdb_request($wa, $Tf);
			if (!$sj) break;
			foreach ($sj->$bi
					 as $tc) $H[] = $tc;
			if ($z && count($H) >= $z) {
				$_GET["next"] = $sj->NextToken;
				break;
			}
			if ($ki && microtime(true) - $Ih > $ki) return
				false;
			$Tf['NextToken'] = $sj->NextToken;
			if ($z) $Tf['SelectExpression'] = preg_replace('~\d+\s*$~', $z - count($H), $Tf['SelectExpression']);
		} while ($sj->NextToken);
		return $H;
	}

	$x = "simpledb";
	$_f = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "IS NOT NULL");
	$od = array();
	$ud = array("count");
	$qc = array(array("json"));
}
$ic["mongo"] = "MongoDB";
if (isset($_GET["mongo"])) {
	$mg = array("mongo", "mongodb");
	define("DRIVER", "mongo");
	if (class_exists('MongoDB')) {
		class
		Min_DB {
			var $extension = "Mongo", $server_info = MongoClient::VERSION, $error, $last_id, $_link, $_db;

			function
			connect($Pi, $Cf) {
				return @new
				MongoClient($Pi, $Cf);
			}

			function
			query($F) {
				return
					false;
			}

			function
			select_db($j) {
				try {
					$this->_db = $this->_link->selectDB($j);
					return
						true;
				} catch (Exception$Ec) {
					$this->error = $Ec->getMessage();
					return
						false;
				}
			}

			function
			quote($P) {
				return $P;
			}
		}

		class
		Min_Result {
			var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

			function
			__construct($G) {
				foreach ($G
						 as $fe) {
					$I = array();
					foreach ($fe
							 as $y => $X) {
						if (is_a($X, 'MongoBinData')) $this->_charset[$y] = 63;
						$I[$y] = (is_a($X, 'MongoId') ? 'ObjectId("' . strval($X) . '")' : (is_a($X, 'MongoDate') ? gmdate("Y-m-d H:i:s", $X->sec) . " GMT" : (is_a($X, 'MongoBinData') ? $X->bin : (is_a($X, 'MongoRegex') ? strval($X) : (is_object($X) ? get_class($X) : $X)))));
					}
					$this->_rows[] = $I;
					foreach ($I
							 as $y => $X) {
						if (!isset($this->_rows[0][$y])) $this->_rows[0][$y] = null;
					}
				}
				$this->num_rows = count($this->_rows);
			}

			function
			fetch_assoc() {
				$I = current($this->_rows);
				if (!$I) return $I;
				$H = array();
				foreach ($this->_rows[0] as $y => $X) $H[$y] = $I[$y];
				next($this->_rows);
				return $H;
			}

			function
			fetch_row() {
				$H = $this->fetch_assoc();
				if (!$H) return $H;
				return
					array_values($H);
			}

			function
			fetch_field() {
				$le = array_keys($this->_rows[0]);
				$B = $le[$this->_offset++];
				return (object)array('name' => $B, 'charsetnr' => $this->_charset[$B],);
			}
		}

		class
		Min_Driver
			extends
			Min_SQL {
			public $pg = "_id";

			function
			select($Q, $K, $Z, $rd, $Ef = array(), $z = 1, $D = 0, $rg = false) {
				$K = ($K == array("*") ? array() : array_fill_keys($K, true));
				$_h = array();
				foreach ($Ef
						 as $X) {
					$X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
					$_h[$X] = ($Gb ? -1 : 1);
				}
				return
					new
					Min_Result($this->_conn->_db->selectCollection($Q)->find(array(), $K)->sort($_h)->limit($z != "" ? +$z : 0)->skip($D * $z));
			}

			function
			insert($Q, $N) {
				try {
					$H = $this->_conn->_db->selectCollection($Q)->insert($N);
					$this->_conn->errno = $H['code'];
					$this->_conn->error = $H['err'];
					$this->_conn->last_id = $N['_id'];
					return !$H['err'];
				} catch (Exception$Ec) {
					$this->_conn->error = $Ec->getMessage();
					return
						false;
				}
			}
		}

		function
		get_databases($ed) {
			global $h;
			$H = array();
			$Ub = $h->_link->listDBs();
			foreach ($Ub['databases'] as $l) $H[] = $l['name'];
			return $H;
		}

		function
		count_tables($k) {
			global $h;
			$H = array();
			foreach ($k
					 as $l) $H[$l] = count($h->_link->selectDB($l)->getCollectionNames(true));
			return $H;
		}

		function
		tables_list() {
			global $h;
			return
				array_fill_keys($h->_db->getCollectionNames(true), 'table');
		}

		function
		drop_databases($k) {
			global $h;
			foreach ($k
					 as $l) {
				$Rg = $h->_link->selectDB($l)->drop();
				if (!$Rg['ok']) return
					false;
			}
			return
				true;
		}

		function
		indexes($Q, $i = null) {
			global $h;
			$H = array();
			foreach ($h->_db->selectCollection($Q)->getIndexInfo() as $v) {
				$cc = array();
				foreach ($v["key"] as $e => $T) $cc[] = ($T == -1 ? '1' : null);
				$H[$v["name"]] = array("type" => ($v["name"] == "_id_" ? "PRIMARY" : ($v["unique"] ? "UNIQUE" : "INDEX")), "columns" => array_keys($v["key"]), "lengths" => array(), "descs" => $cc,);
			}
			return $H;
		}

		function
		fields($Q) {
			return
				fields_from_edit();
		}

		function
		found_rows($R, $Z) {
			global $h;
			return $h->_db->selectCollection($_GET["select"])->count($Z);
		}

		$_f = array("=");
	} elseif (class_exists('MongoDB\Driver\Manager')) {
		class
		Min_DB {
			var $extension = "MongoDB", $server_info = MONGODB_VERSION, $error, $last_id;
			var $_link;
			var $_db, $_db_name;

			function
			connect($Pi, $Cf) {
				$lb = 'MongoDB\Driver\Manager';
				return
					new$lb($Pi, $Cf);
			}

			function
			query($F) {
				return
					false;
			}

			function
			select_db($j) {
				$this->_db_name = $j;
				return
					true;
			}

			function
			quote($P) {
				return $P;
			}
		}

		class
		Min_Result {
			var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

			function
			__construct($G) {
				foreach ($G
						 as $fe) {
					$I = array();
					foreach ($fe
							 as $y => $X) {
						if (is_a($X, 'MongoDB\BSON\Binary')) $this->_charset[$y] = 63;
						$I[$y] = (is_a($X, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . strval($X) . '")' : (is_a($X, 'MongoDB\BSON\UTCDatetime') ? $X->toDateTime()->format('Y-m-d H:i:s') : (is_a($X, 'MongoDB\BSON\Binary') ? $X->bin : (is_a($X, 'MongoDB\BSON\Regex') ? strval($X) : (is_object($X) ? json_encode($X, 256) : $X)))));
					}
					$this->_rows[] = $I;
					foreach ($I
							 as $y => $X) {
						if (!isset($this->_rows[0][$y])) $this->_rows[0][$y] = null;
					}
				}
				$this->num_rows = $G->count;
			}

			function
			fetch_assoc() {
				$I = current($this->_rows);
				if (!$I) return $I;
				$H = array();
				foreach ($this->_rows[0] as $y => $X) $H[$y] = $I[$y];
				next($this->_rows);
				return $H;
			}

			function
			fetch_row() {
				$H = $this->fetch_assoc();
				if (!$H) return $H;
				return
					array_values($H);
			}

			function
			fetch_field() {
				$le = array_keys($this->_rows[0]);
				$B = $le[$this->_offset++];
				return (object)array('name' => $B, 'charsetnr' => $this->_charset[$B],);
			}
		}

		class
		Min_Driver
			extends
			Min_SQL {
			public $pg = "_id";

			function
			select($Q, $K, $Z, $rd, $Ef = array(), $z = 1, $D = 0, $rg = false) {
				global $h;
				$K = ($K == array("*") ? array() : array_fill_keys($K, 1));
				if (count($K) && !isset($K['_id'])) $K['_id'] = 0;
				$Z = where_to_query($Z);
				$_h = array();
				foreach ($Ef
						 as $X) {
					$X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
					$_h[$X] = ($Gb ? -1 : 1);
				}
				if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) $z = $_GET['limit'];
				$z = min(200, max(1, (int)$z));
				$xh = $D * $z;
				$lb = 'MongoDB\Driver\Query';
				$F = new$lb($Z, array('projection' => $K, 'limit' => $z, 'skip' => $xh, 'sort' => $_h));
				$Ug = $h->_link->executeQuery("$h->_db_name.$Q", $F);
				return
					new
					Min_Result($Ug);
			}

			function
			update($Q, $N, $Ag, $z = 0, $L = "\n") {
				global $h;
				$l = $h->_db_name;
				$Z = sql_query_where_parser($Ag);
				$lb = 'MongoDB\Driver\BulkWrite';
				$ab = new$lb(array());
				if (isset($N['_id'])) unset($N['_id']);
				$Og = array();
				foreach ($N
						 as $y => $Y) {
					if ($Y == 'NULL') {
						$Og[$y] = 1;
						unset($N[$y]);
					}
				}
				$Oi = array('$set' => $N);
				if (count($Og)) $Oi['$unset'] = $Og;
				$ab->update($Z, $Oi, array('upsert' => false));
				$Ug = $h->_link->executeBulkWrite("$l.$Q", $ab);
				$h->affected_rows = $Ug->getModifiedCount();
				return
					true;
			}

			function
			delete($Q, $Ag, $z = 0) {
				global $h;
				$l = $h->_db_name;
				$Z = sql_query_where_parser($Ag);
				$lb = 'MongoDB\Driver\BulkWrite';
				$ab = new$lb(array());
				$ab->delete($Z, array('limit' => $z));
				$Ug = $h->_link->executeBulkWrite("$l.$Q", $ab);
				$h->affected_rows = $Ug->getDeletedCount();
				return
					true;
			}

			function
			insert($Q, $N) {
				global $h;
				$l = $h->_db_name;
				$lb = 'MongoDB\Driver\BulkWrite';
				$ab = new$lb(array());
				if (isset($N['_id']) && empty($N['_id'])) unset($N['_id']);
				$ab->insert($N);
				$Ug = $h->_link->executeBulkWrite("$l.$Q", $ab);
				$h->affected_rows = $Ug->getInsertedCount();
				return
					true;
			}
		}

		function
		get_databases($ed) {
			global $h;
			$H = array();
			$lb = 'MongoDB\Driver\Command';
			$tb = new$lb(array('listDatabases' => 1));
			$Ug = $h->_link->executeCommand('admin', $tb);
			foreach ($Ug
					 as $Ub) {
				foreach ($Ub->databases
						 as $l) $H[] = $l->name;
			}
			return $H;
		}

		function
		count_tables($k) {
			$H = array();
			return $H;
		}

		function
		tables_list() {
			global $h;
			$lb = 'MongoDB\Driver\Command';
			$tb = new$lb(array('listCollections' => 1));
			$Ug = $h->_link->executeCommand($h->_db_name, $tb);
			$rb = array();
			foreach ($Ug
					 as $G) $rb[$G->name] = 'table';
			return $rb;
		}

		function
		drop_databases($k) {
			return
				false;
		}

		function
		indexes($Q, $i = null) {
			global $h;
			$H = array();
			$lb = 'MongoDB\Driver\Command';
			$tb = new$lb(array('listIndexes' => $Q));
			$Ug = $h->_link->executeCommand($h->_db_name, $tb);
			foreach ($Ug
					 as $v) {
				$cc = array();
				$f = array();
				foreach (get_object_vars($v->key) as $e => $T) {
					$cc[] = ($T == -1 ? '1' : null);
					$f[] = $e;
				}
				$H[$v->name] = array("type" => ($v->name == "_id_" ? "PRIMARY" : (isset($v->unique) ? "UNIQUE" : "INDEX")), "columns" => $f, "lengths" => array(), "descs" => $cc,);
			}
			return $H;
		}

		function
		fields($Q) {
			$p = fields_from_edit();
			if (!count($p)) {
				global $m;
				$G = $m->select($Q, array("*"), null, null, array(), 10);
				while ($I = $G->fetch_assoc()) {
					foreach ($I
							 as $y => $X) {
						$I[$y] = null;
						$p[$y] = array("field" => $y, "type" => "string", "null" => ($y != $m->primary), "auto_increment" => ($y == $m->primary), "privileges" => array("insert" => 1, "select" => 1, "update" => 1,),);
					}
				}
			}
			return $p;
		}

		function
		found_rows($R, $Z) {
			global $h;
			$Z = where_to_query($Z);
			$lb = 'MongoDB\Driver\Command';
			$tb = new$lb(array('count' => $R['Name'], 'query' => $Z));
			$Ug = $h->_link->executeCommand($h->_db_name, $tb);
			$si = $Ug->toArray();
			return $si[0]->n;
		}

		function
		sql_query_where_parser($Ag) {
			$Ag = trim(preg_replace('/WHERE[\s]?[(]?\(?/', '', $Ag));
			$Ag = preg_replace('/\)\)\)$/', ')', $Ag);
			$pj = explode(' AND ', $Ag);
			$qj = explode(') OR (', $Ag);
			$Z = array();
			foreach ($pj
					 as $nj) $Z[] = trim($nj);
			if (count($qj) == 1) $qj = array(); elseif (count($qj) > 1) $Z = array();
			return
				where_to_query($Z, $qj);
		}

		function
		where_to_query($lj = array(), $mj = array()) {
			global $b;
			$Pb = array();
			foreach (array('and' => $lj, 'or' => $mj) as $T => $Z) {
				if (is_array($Z)) {
					foreach ($Z
							 as $Lc) {
						list($ob, $yf, $X) = explode(" ", $Lc, 3);
						if ($ob == "_id") {
							$X = str_replace('MongoDB\BSON\ObjectID("', "", $X);
							$X = str_replace('")', "", $X);
							$lb = 'MongoDB\BSON\ObjectID';
							$X = new$lb($X);
						}
						if (!in_array($yf, $b->operators)) continue;
						if (preg_match('~^\(f\)(.+)~', $yf, $A)) {
							$X = (float)$X;
							$yf = $A[1];
						} elseif (preg_match('~^\(date\)(.+)~', $yf, $A)) {
							$Rb = new
							DateTime($X);
							$lb = 'MongoDB\BSON\UTCDatetime';
							$X = new$lb($Rb->getTimestamp() * 1000);
							$yf = $A[1];
						}
						switch ($yf) {
							case'=':
								$yf = '$eq';
								break;
							case'!=':
								$yf = '$ne';
								break;
							case'>':
								$yf = '$gt';
								break;
							case'<':
								$yf = '$lt';
								break;
							case'>=':
								$yf = '$gte';
								break;
							case'<=':
								$yf = '$lte';
								break;
							case'regex':
								$yf = '$regex';
								break;
							default:
								continue
								2;
						}
						if ($T == 'and') $Pb['$and'][] = array($ob => array($yf => $X)); elseif ($T == 'or') $Pb['$or'][] = array($ob => array($yf => $X));
					}
				}
			}
			return $Pb;
		}

		$_f = array("=", "!=", ">", "<", ">=", "<=", "regex", "(f)=", "(f)!=", "(f)>", "(f)<", "(f)>=", "(f)<=", "(date)=", "(date)!=", "(date)>", "(date)<", "(date)>=", "(date)<=",);
	}
	function
	table($u) {
		return $u;
	}

	function
	idf_escape($u) {
		return $u;
	}

	function
	table_status($B = "", $Sc = false) {
		$H = array();
		foreach (tables_list() as $Q => $T) {
			$H[$Q] = array("Name" => $Q);
			if ($B == $Q) return $H[$Q];
		}
		return $H;
	}

	function
	create_database($l, $d) {
		return
			true;
	}

	function
	last_id() {
		global $h;
		return $h->last_id;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	collations() {
		return
			array();
	}

	function
	logged_user() {
		global $b;
		$Kb = $b->credentials();
		return $Kb[1];
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		list($M, $V, $E) = $b->credentials();
		$Cf = array();
		if ($V . $E != "") {
			$Cf["username"] = $V;
			$Cf["password"] = $E;
		}
		$l = $b->database();
		if ($l != "") $Cf["db"] = $l;
		if (($Ma = getenv("MONGO_AUTH_SOURCE"))) $Cf["authSource"] = $Ma;
		try {
			$h->_link = $h->connect("mongodb://$M", $Cf);
			if ($E != "") {
				$Cf["password"] = "";
				try {
					$h->connect("mongodb://$M", $Cf);
					return
						lang(22);
				} catch (Exception$Ec) {
				}
			}
			return $h;
		} catch (Exception$Ec) {
			return $Ec->getMessage();
		}
	}

	function
	alter_indexes($Q, $c) {
		global $h;
		foreach ($c
				 as $X) {
			list($T, $B, $N) = $X;
			if ($N == "DROP") $H = $h->_db->command(array("deleteIndexes" => $Q, "index" => $B)); else {
				$f = array();
				foreach ($N
						 as $e) {
					$e = preg_replace('~ DESC$~', '', $e, 1, $Gb);
					$f[$e] = ($Gb ? -1 : 1);
				}
				$H = $h->_db->selectCollection($Q)->ensureIndex($f, array("unique" => ($T == "UNIQUE"), "name" => $B,));
			}
			if ($H['errmsg']) {
				$h->error = $H['errmsg'];
				return
					false;
			}
		}
		return
			true;
	}

	function
	support($Tc) {
		return
			preg_match("~database|indexes|descidx~", $Tc);
	}

	function
	db_collation($l, $qb) {
	}

	function
	information_schema() {
	}

	function
	is_view($R) {
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	foreign_keys($Q) {
		return
			array();
	}

	function
	fk_support($R) {
	}

	function
	engines() {
		return
			array();
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		global $h;
		if ($Q == "") {
			$h->_db->createCollection($B);
			return
				true;
		}
	}

	function
	drop_tables($S) {
		global $h;
		foreach ($S
				 as $Q) {
			$Rg = $h->_db->selectCollection($Q)->drop();
			if (!$Rg['ok']) return
				false;
		}
		return
			true;
	}

	function
	truncate_tables($S) {
		global $h;
		foreach ($S
				 as $Q) {
			$Rg = $h->_db->selectCollection($Q)->remove();
			if (!$Rg['ok']) return
				false;
		}
		return
			true;
	}

	$x = "mongo";
	$od = array();
	$ud = array();
	$qc = array(array("json"));
}
$ic["elastic"] = "Elasticsearch (beta)";
if (isset($_GET["elastic"])) {
	$mg = array("json + allow_url_fopen");
	define("DRIVER", "elastic");
	if (function_exists('json_decode') && ini_bool('allow_url_fopen')) {
		class
		Min_DB {
			var $extension = "JSON", $server_info, $errno, $error, $_url;

			function
			rootQuery($dg, $Bb = array(), $We = 'GET') {
				@ini_set('track_errors', 1);
				$Xc = @file_get_contents("$this->_url/" . ltrim($dg, '/'), false, stream_context_create(array('http' => array('method' => $We, 'content' => $Bb === null ? $Bb : json_encode($Bb), 'header' => 'Content-Type: application/json', 'ignore_errors' => 1,))));
				if (!$Xc) {
					$this->error = $php_errormsg;
					return $Xc;
				}
				if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
					$this->error = $Xc;
					return
						false;
				}
				$H = json_decode($Xc, true);
				if ($H === null) {
					$this->errno = json_last_error();
					if (function_exists('json_last_error_msg')) $this->error = json_last_error_msg(); else {
						$Ab = get_defined_constants(true);
						foreach ($Ab['json'] as $B => $Y) {
							if ($Y == $this->errno && preg_match('~^JSON_ERROR_~', $B)) {
								$this->error = $B;
								break;
							}
						}
					}
				}
				return $H;
			}

			function
			query($dg, $Bb = array(), $We = 'GET') {
				return $this->rootQuery(($this->_db != "" ? "$this->_db/" : "/") . ltrim($dg, '/'), $Bb, $We);
			}

			function
			connect($M, $V, $E) {
				preg_match('~^(https?://)?(.*)~', $M, $A);
				$this->_url = ($A[1] ? $A[1] : "http://") . "$V:$E@$A[2]";
				$H = $this->query('');
				if ($H) $this->server_info = $H['version']['number'];
				return (bool)$H;
			}

			function
			select_db($j) {
				$this->_db = $j;
				return
					true;
			}

			function
			quote($P) {
				return $P;
			}
		}

		class
		Min_Result {
			var $num_rows, $_rows;

			function
			__construct($J) {
				$this->num_rows = count($J);
				$this->_rows = $J;
				reset($this->_rows);
			}

			function
			fetch_assoc() {
				$H = current($this->_rows);
				next($this->_rows);
				return $H;
			}

			function
			fetch_row() {
				return
					array_values($this->fetch_assoc());
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		select($Q, $K, $Z, $rd, $Ef = array(), $z = 1, $D = 0, $rg = false) {
			global $b;
			$Pb = array();
			$F = "$Q/_search";
			if ($K != array("*")) $Pb["fields"] = $K;
			if ($Ef) {
				$_h = array();
				foreach ($Ef
						 as $ob) {
					$ob = preg_replace('~ DESC$~', '', $ob, 1, $Gb);
					$_h[] = ($Gb ? array($ob => "desc") : $ob);
				}
				$Pb["sort"] = $_h;
			}
			if ($z) {
				$Pb["size"] = +$z;
				if ($D) $Pb["from"] = ($D * $z);
			}
			foreach ($Z
					 as $X) {
				list($ob, $yf, $X) = explode(" ", $X, 3);
				if ($ob == "_id") $Pb["query"]["ids"]["values"][] = $X; elseif ($ob . $X != "") {
					$fi = array("term" => array(($ob != "" ? $ob : "_all") => $X));
					if ($yf == "=") $Pb["query"]["filtered"]["filter"]["and"][] = $fi; else$Pb["query"]["filtered"]["query"]["bool"]["must"][] = $fi;
				}
			}
			if ($Pb["query"] && !$Pb["query"]["filtered"]["query"] && !$Pb["query"]["ids"]) $Pb["query"]["filtered"]["query"] = array("match_all" => array());
			$Ih = microtime(true);
			$hh = $this->_conn->query($F, $Pb);
			if ($rg) echo $b->selectQuery("$F: " . json_encode($Pb), $Ih, !$hh);
			if (!$hh) return
				false;
			$H = array();
			foreach ($hh['hits']['hits'] as $Dd) {
				$I = array();
				if ($K == array("*")) $I["_id"] = $Dd["_id"];
				$p = $Dd['_source'];
				if ($K != array("*")) {
					$p = array();
					foreach ($K
							 as $y) $p[$y] = $Dd['fields'][$y];
				}
				foreach ($p
						 as $y => $X) {
					if ($Pb["fields"]) $X = $X[0];
					$I[$y] = (is_array($X) ? json_encode($X) : $X);
				}
				$H[] = $I;
			}
			return
				new
				Min_Result($H);
		}

		function
		update($T, $Fg, $Ag, $z = 0, $L = "\n") {
			$bg = preg_split('~ *= *~', $Ag);
			if (count($bg) == 2) {
				$t = trim($bg[1]);
				$F = "$T/$t";
				return $this->_conn->query($F, $Fg, 'POST');
			}
			return
				false;
		}

		function
		insert($T, $Fg) {
			$t = "";
			$F = "$T/$t";
			$Rg = $this->_conn->query($F, $Fg, 'POST');
			$this->_conn->last_id = $Rg['_id'];
			return $Rg['created'];
		}

		function
		delete($T, $Ag, $z = 0) {
			$Id = array();
			if (is_array($_GET["where"]) && $_GET["where"]["_id"]) $Id[] = $_GET["where"]["_id"];
			if (is_array($_POST['check'])) {
				foreach ($_POST['check'] as $eb) {
					$bg = preg_split('~ *= *~', $eb);
					if (count($bg) == 2) $Id[] = trim($bg[1]);
				}
			}
			$this->_conn->affected_rows = 0;
			foreach ($Id
					 as $t) {
				$F = "{$T}/{$t}";
				$Rg = $this->_conn->query($F, '{}', 'DELETE');
				if (is_array($Rg) && $Rg['found'] == true) $this->_conn->affected_rows++;
			}
			return $this->_conn->affected_rows;
		}
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		list($M, $V, $E) = $b->credentials();
		if ($E != "" && $h->connect($M, $V, "")) return
			lang(22);
		if ($h->connect($M, $V, $E)) return $h;
		return $h->error;
	}

	function
	support($Tc) {
		return
			preg_match("~database|table|columns~", $Tc);
	}

	function
	logged_user() {
		global $b;
		$Kb = $b->credentials();
		return $Kb[1];
	}

	function
	get_databases() {
		global $h;
		$H = $h->rootQuery('_aliases');
		if ($H) {
			$H = array_keys($H);
			sort($H, SORT_STRING);
		}
		return $H;
	}

	function
	collations() {
		return
			array();
	}

	function
	db_collation($l, $qb) {
	}

	function
	engines() {
		return
			array();
	}

	function
	count_tables($k) {
		global $h;
		$H = array();
		$G = $h->query('_stats');
		if ($G && $G['indices']) {
			$Qd = $G['indices'];
			foreach ($Qd
					 as $Pd => $Jh) {
				$Od = $Jh['total']['indexing'];
				$H[$Pd] = $Od['index_total'];
			}
		}
		return $H;
	}

	function
	tables_list() {
		global $h;
		$H = $h->query('_mapping');
		if ($H) $H = array_fill_keys(array_keys($H[$h->_db]["mappings"]), 'table');
		return $H;
	}

	function
	table_status($B = "", $Sc = false) {
		global $h;
		$hh = $h->query("_search", array("size" => 0, "aggregations" => array("count_by_type" => array("terms" => array("field" => "_type")))), "POST");
		$H = array();
		if ($hh) {
			$S = $hh["aggregations"]["count_by_type"]["buckets"];
			foreach ($S
					 as $Q) {
				$H[$Q["key"]] = array("Name" => $Q["key"], "Engine" => "table", "Rows" => $Q["doc_count"],);
				if ($B != "" && $B == $Q["key"]) return $H[$B];
			}
		}
		return $H;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	information_schema() {
	}

	function
	is_view($R) {
	}

	function
	indexes($Q, $i = null) {
		return
			array(array("type" => "PRIMARY", "columns" => array("_id")),);
	}

	function
	fields($Q) {
		global $h;
		$G = $h->query("$Q/_mapping");
		$H = array();
		if ($G) {
			$Ee = $G[$Q]['properties'];
			if (!$Ee) $Ee = $G[$h->_db]['mappings'][$Q]['properties'];
			if ($Ee) {
				foreach ($Ee
						 as $B => $o) {
					$H[$B] = array("field" => $B, "full_type" => $o["type"], "type" => $o["type"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
					if ($o["properties"]) {
						unset($H[$B]["privileges"]["insert"]);
						unset($H[$B]["privileges"]["update"]);
					}
				}
			}
		}
		return $H;
	}

	function
	foreign_keys($Q) {
		return
			array();
	}

	function
	table($u) {
		return $u;
	}

	function
	idf_escape($u) {
		return $u;
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		return $H;
	}

	function
	fk_support($R) {
	}

	function
	found_rows($R, $Z) {
		return
			null;
	}

	function
	create_database($l) {
		global $h;
		return $h->rootQuery(urlencode($l), null, 'PUT');
	}

	function
	drop_databases($k) {
		global $h;
		return $h->rootQuery(urlencode(implode(',', $k)), array(), 'DELETE');
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		global $h;
		$xg = array();
		foreach ($p
				 as $Qc) {
			$Vc = trim($Qc[1][0]);
			$Wc = trim($Qc[1][1] ? $Qc[1][1] : "text");
			$xg[$Vc] = array('type' => $Wc);
		}
		if (!empty($xg)) $xg = array('properties' => $xg);
		return $h->query("_mapping/{$B}", $xg, 'PUT');
	}

	function
	drop_tables($S) {
		global $h;
		$H = true;
		foreach ($S
				 as $Q) $H = $H && $h->query(urlencode($Q), array(), 'DELETE');
		return $H;
	}

	function
	last_id() {
		global $h;
		return $h->last_id;
	}

	$x = "elastic";
	$_f = array("=", "query");
	$od = array();
	$ud = array();
	$qc = array(array("json"));
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("long" => 3, "integer" => 5, "short" => 8, "byte" => 10, "double" => 20, "float" => 66, "half_float" => 12, "scaled_float" => 21), lang(28) => array("date" => 10), lang(25) => array("string" => 65535, "text" => 65535), lang(29) => array("binary" => 255),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
}
$ic["clickhouse"] = "ClickHouse (alpha)";
if (isset($_GET["clickhouse"])) {
	define("DRIVER", "clickhouse");

	class
	Min_DB {
		var $extension = "JSON", $server_info, $errno, $_result, $error, $_url;
		var $_db = 'default';

		function
		rootQuery($l, $F) {
			@ini_set('track_errors', 1);
			$Xc = @file_get_contents("$this->_url/?database=$l", false, stream_context_create(array('http' => array('method' => 'POST', 'content' => $this->isQuerySelectLike($F) ? "$F FORMAT JSONCompact" : $F, 'header' => 'Content-type: application/x-www-form-urlencoded', 'ignore_errors' => 1,))));
			if ($Xc === false) {
				$this->error = $php_errormsg;
				return $Xc;
			}
			if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
				$this->error = $Xc;
				return
					false;
			}
			$H = json_decode($Xc, true);
			if ($H === null) {
				if (!$this->isQuerySelectLike($F) && $Xc === '') return
					true;
				$this->errno = json_last_error();
				if (function_exists('json_last_error_msg')) $this->error = json_last_error_msg(); else {
					$Ab = get_defined_constants(true);
					foreach ($Ab['json'] as $B => $Y) {
						if ($Y == $this->errno && preg_match('~^JSON_ERROR_~', $B)) {
							$this->error = $B;
							break;
						}
					}
				}
			}
			return
				new
				Min_Result($H);
		}

		function
		isQuerySelectLike($F) {
			return (bool)preg_match('~^(select|show)~i', $F);
		}

		function
		query($F) {
			return $this->rootQuery($this->_db, $F);
		}

		function
		connect($M, $V, $E) {
			preg_match('~^(https?://)?(.*)~', $M, $A);
			$this->_url = ($A[1] ? $A[1] : "http://") . "$V:$E@$A[2]";
			$H = $this->query('SELECT 1');
			return (bool)$H;
		}

		function
		select_db($j) {
			$this->_db = $j;
			return
				true;
		}

		function
		quote($P) {
			return "'" . addcslashes($P, "\\'") . "'";
		}

		function
		multi_query($F) {
			return $this->_result = $this->query($F);
		}

		function
		store_result() {
			return $this->_result;
		}

		function
		next_result() {
			return
				false;
		}

		function
		result($F, $o = 0) {
			$G = $this->query($F);
			return $G['data'];
		}
	}

	class
	Min_Result {
		var $num_rows, $_rows, $columns, $meta, $_offset = 0;

		function
		__construct($G) {
			$this->num_rows = $G['rows'];
			$this->_rows = $G['data'];
			$this->meta = $G['meta'];
			$this->columns = array_column($this->meta, 'name');
			reset($this->_rows);
		}

		function
		fetch_assoc() {
			$I = current($this->_rows);
			next($this->_rows);
			return $I === false ? false : array_combine($this->columns, $I);
		}

		function
		fetch_row() {
			$I = current($this->_rows);
			next($this->_rows);
			return $I;
		}

		function
		fetch_field() {
			$e = $this->_offset++;
			$H = new
			stdClass;
			if ($e < count($this->columns)) {
				$H->name = $this->meta[$e]['name'];
				$H->orgname = $H->name;
				$H->type = $this->meta[$e]['type'];
			}
			return $H;
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		delete($Q, $Ag, $z = 0) {
			if ($Ag === '') $Ag = 'WHERE 1=1';
			return
				queries("ALTER TABLE " . table($Q) . " DELETE $Ag");
		}

		function
		update($Q, $N, $Ag, $z = 0, $L = "\n") {
			$aj = array();
			foreach ($N
					 as $y => $X) $aj[] = "$y = $X";
			$F = $L . implode(",$L", $aj);
			return
				queries("ALTER TABLE " . table($Q) . " UPDATE $F$Ag");
		}
	}

	function
	idf_escape($u) {
		return "`" . str_replace("`", "``", $u) . "`";
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	explain($h, $F) {
		return '';
	}

	function
	found_rows($R, $Z) {
		$J = get_vals("SELECT COUNT(*) FROM " . idf_escape($R["Name"]) . ($Z ? " WHERE " . implode(" AND ", $Z) : ""));
		return
			empty($J) ? false : $J[0];
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		$c = $Ef = array();
		foreach ($p
				 as $o) {
			if ($o[1][2] === " NULL") $o[1][1] = " Nullable({$o[1][1]})"; elseif ($o[1][2] === ' NOT NULL') $o[1][2] = '';
			if ($o[1][3]) $o[1][3] = '';
			$c[] = ($o[1] ? ($Q != "" ? ($o[0] != "" ? "MODIFY COLUMN " : "ADD COLUMN ") : " ") . implode($o[1]) : "DROP COLUMN " . idf_escape($o[0]));
			$Ef[] = $o[1][0];
		}
		$c = array_merge($c, $gd);
		$O = ($yc ? " ENGINE " . $yc : "");
		if ($Q == "") return
			queries("CREATE TABLE " . table($B) . " (\n" . implode(",\n", $c) . "\n)$O$Zf" . ' ORDER BY (' . implode(',', $Ef) . ')');
		if ($Q != $B) {
			$G = queries("RENAME TABLE " . table($Q) . " TO " . table($B));
			if ($c) $Q = $B; else
				return $G;
		}
		if ($O) $c[] = ltrim($O);
		return ($c || $Zf ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c) . $Zf) : true);
	}

	function
	truncate_tables($S) {
		return
			apply_queries("TRUNCATE TABLE", $S);
	}

	function
	drop_views($fj) {
		return
			drop_tables($fj);
	}

	function
	drop_tables($S) {
		return
			apply_queries("DROP TABLE", $S);
	}

	function
	connect() {
		global $b;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) return $h;
		return $h->error;
	}

	function
	get_databases($ed) {
		global $h;
		$G = get_rows('SHOW DATABASES');
		$H = array();
		foreach ($G
				 as $I) $H[] = $I['name'];
		sort($H);
		return $H;
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return " $F$Z" . ($z !== null ? $L . "LIMIT $z" . ($C ? ", $C" : "") : "");
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return
			limit($F, $Z, 1, 0, $L);
	}

	function
	db_collation($l, $qb) {
	}

	function
	engines() {
		return
			array('MergeTree');
	}

	function
	logged_user() {
		global $b;
		$Kb = $b->credentials();
		return $Kb[1];
	}

	function
	tables_list() {
		$G = get_rows('SHOW TABLES');
		$H = array();
		foreach ($G
				 as $I) $H[$I['name']] = 'table';
		ksort($H);
		return $H;
	}

	function
	count_tables($k) {
		return
			array();
	}

	function
	table_status($B = "", $Sc = false) {
		global $h;
		$H = array();
		$S = get_rows("SELECT name, engine FROM system.tables WHERE database = " . q($h->_db));
		foreach ($S
				 as $Q) {
			$H[$Q['name']] = array('Name' => $Q['name'], 'Engine' => $Q['engine'],);
			if ($B === $Q['name']) return $H[$Q['name']];
		}
		return $H;
	}

	function
	is_view($R) {
		return
			false;
	}

	function
	fk_support($R) {
		return
			false;
	}

	function
	convert_field($o) {
	}

	function
	unconvert_field($o, $H) {
		if (in_array($o['type'], array("Int8", "Int16", "Int32", "Int64", "UInt8", "UInt16", "UInt32", "UInt64", "Float32", "Float64"))) return "to$o[type]($H)";
		return $H;
	}

	function
	fields($Q) {
		$H = array();
		$G = get_rows("SELECT name, type, default_expression FROM system.columns WHERE " . idf_escape('table') . " = " . q($Q));
		foreach ($G
				 as $I) {
			$T = trim($I['type']);
			$kf = strpos($T, 'Nullable(') === 0;
			$H[trim($I['name'])] = array("field" => trim($I['name']), "full_type" => $T, "type" => $T, "default" => trim($I['default_expression']), "null" => $kf, "auto_increment" => '0', "privileges" => array("insert" => 1, "select" => 1, "update" => 0),);
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		return
			array();
	}

	function
	foreign_keys($Q) {
		return
			array();
	}

	function
	collations() {
		return
			array();
	}

	function
	information_schema($l) {
		return
			false;
	}

	function
	error() {
		global $h;
		return
			h($h->error);
	}

	function
	types() {
		return
			array();
	}

	function
	schemas() {
		return
			array();
	}

	function
	get_schema() {
		return "";
	}

	function
	set_schema($fh) {
		return
			true;
	}

	function
	auto_increment() {
		return '';
	}

	function
	last_id() {
		return
			0;
	}

	function
	support($Tc) {
		return
			preg_match("~^(columns|sql|status|table|drop_col)$~", $Tc);
	}

	$x = "clickhouse";
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("Int8" => 3, "Int16" => 5, "Int32" => 10, "Int64" => 19, "UInt8" => 3, "UInt16" => 5, "UInt32" => 10, "UInt64" => 20, "Float32" => 7, "Float64" => 16, 'Decimal' => 38, 'Decimal32' => 9, 'Decimal64' => 18, 'Decimal128' => 38), lang(28) => array("Date" => 13, "DateTime" => 20), lang(25) => array("String" => 0), lang(29) => array("FixedString" => 0),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
	$Ni = array();
	$_f = array("=", "<", ">", "<=", ">=", "!=", "~", "!~", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL");
	$od = array();
	$ud = array("avg", "count", "count distinct", "max", "min", "sum");
	$qc = array();
}
$ic = array("server" => "MySQL") + $ic;
if (!defined("DRIVER")) {
	$mg = array("MySQLi", "MySQL", "PDO_MySQL");
	define("DRIVER", "server");
	if (extension_loaded("mysqli")) {
		class
		Min_DB
			extends
			MySQLi {
			var $extension = "MySQLi";

			function
			__construct() {
				parent::init();
			}

			function
			connect($M = "", $V = "", $E = "", $j = null, $ig = null, $zh = null) {
				global $b;
				mysqli_report(MYSQLI_REPORT_OFF);
				list($Ed, $ig) = explode(":", $M, 2);
				$Hh = $b->connectSsl();
				if ($Hh) $this->ssl_set($Hh['key'], $Hh['cert'], $Hh['ca'], '', '');
				$H = @$this->real_connect(($M != "" ? $Ed : ini_get("mysqli.default_host")), ($M . $V != "" ? $V : ini_get("mysqli.default_user")), ($M . $V . $E != "" ? $E : ini_get("mysqli.default_pw")), $j, (is_numeric($ig) ? $ig : ini_get("mysqli.default_port")), (!is_numeric($ig) ? $ig : $zh), ($Hh ? 64 : 0));
				$this->options(MYSQLI_OPT_LOCAL_INFILE, false);
				return $H;
			}

			function
			set_charset($db) {
				if (parent::set_charset($db)) return
					true;
				parent::set_charset('utf8');
				return $this->query("SET NAMES $db");
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!$G) return
					false;
				$I = $G->fetch_array();
				return $I[$o];
			}

			function
			quote($P) {
				return "'" . $this->escape_string($P) . "'";
			}
		}
	} elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
		class
		Min_DB {
			var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;

			function
			connect($M, $V, $E) {
				if (ini_bool("mysql.allow_local_infile")) {
					$this->error = lang(32, "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
					return
						false;
				}
				$this->_link = @mysql_connect(($M != "" ? $M : ini_get("mysql.default_host")), ("$M$V" != "" ? $V : ini_get("mysql.default_user")), ("$M$V$E" != "" ? $E : ini_get("mysql.default_password")), true, 131072);
				if ($this->_link) $this->server_info = mysql_get_server_info($this->_link); else$this->error = mysql_error();
				return (bool)$this->_link;
			}

			function
			set_charset($db) {
				if (function_exists('mysql_set_charset')) {
					if (mysql_set_charset($db, $this->_link)) return
						true;
					mysql_set_charset('utf8', $this->_link);
				}
				return $this->query("SET NAMES $db");
			}

			function
			quote($P) {
				return "'" . mysql_real_escape_string($P, $this->_link) . "'";
			}

			function
			select_db($j) {
				return
					mysql_select_db($j, $this->_link);
			}

			function
			query($F, $Hi = false) {
				$G = @($Hi ? mysql_unbuffered_query($F, $this->_link) : mysql_query($F, $this->_link));
				$this->error = "";
				if (!$G) {
					$this->errno = mysql_errno($this->_link);
					$this->error = mysql_error($this->_link);
					return
						false;
				}
				if ($G === true) {
					$this->affected_rows = mysql_affected_rows($this->_link);
					$this->info = mysql_info($this->_link);
					return
						true;
				}
				return
					new
					Min_Result($G);
			}

			function
			multi_query($F) {
				return $this->_result = $this->query($F);
			}

			function
			store_result() {
				return $this->_result;
			}

			function
			next_result() {
				return
					false;
			}

			function
			result($F, $o = 0) {
				$G = $this->query($F);
				if (!$G || !$G->num_rows) return
					false;
				return
					mysql_result($G->_result, 0, $o);
			}
		}

		class
		Min_Result {
			var $num_rows, $_result, $_offset = 0;

			function
			__construct($G) {
				$this->_result = $G;
				$this->num_rows = mysql_num_rows($G);
			}

			function
			fetch_assoc() {
				return
					mysql_fetch_assoc($this->_result);
			}

			function
			fetch_row() {
				return
					mysql_fetch_row($this->_result);
			}

			function
			fetch_field() {
				$H = mysql_fetch_field($this->_result, $this->_offset++);
				$H->orgtable = $H->table;
				$H->orgname = $H->name;
				$H->charsetnr = ($H->blob ? 63 : 0);
				return $H;
			}

			function
			__destruct() {
				mysql_free_result($this->_result);
			}
		}
	} elseif (extension_loaded("pdo_mysql")) {
		class
		Min_DB
			extends
			Min_PDO {
			var $extension = "PDO_MySQL";

			function
			connect($M, $V, $E) {
				global $b;
				$Cf = array(PDO::MYSQL_ATTR_LOCAL_INFILE => false);
				$Hh = $b->connectSsl();
				if ($Hh) {
					if (!empty($Hh['key'])) $Cf[PDO::MYSQL_ATTR_SSL_KEY] = $Hh['key'];
					if (!empty($Hh['cert'])) $Cf[PDO::MYSQL_ATTR_SSL_CERT] = $Hh['cert'];
					if (!empty($Hh['ca'])) $Cf[PDO::MYSQL_ATTR_SSL_CA] = $Hh['ca'];
				}
				$this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $E, $Cf);
				return
					true;
			}

			function
			set_charset($db) {
				$this->query("SET NAMES $db");
			}

			function
			select_db($j) {
				return $this->query("USE " . idf_escape($j));
			}

			function
			query($F, $Hi = false) {
				$this->setAttribute(1000, !$Hi);
				return
					parent::query($F, $Hi);
			}
		}
	}

	class
	Min_Driver
		extends
		Min_SQL {
		function
		insert($Q, $N) {
			return ($N ? parent::insert($Q, $N) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
		}

		function
		insertUpdate($Q, $J, $pg) {
			$f = array_keys(reset($J));
			$ng = "INSERT INTO " . table($Q) . " (" . implode(", ", $f) . ") VALUES\n";
			$aj = array();
			foreach ($f
					 as $y) $aj[$y] = "$y = VALUES($y)";
			$Ph = "\nON DUPLICATE KEY UPDATE " . implode(", ", $aj);
			$aj = array();
			$ye = 0;
			foreach ($J
					 as $N) {
				$Y = "(" . implode(", ", $N) . ")";
				if ($aj && (strlen($ng) + $ye + strlen($Y) + strlen($Ph) > 1e6)) {
					if (!queries($ng . implode(",\n", $aj) . $Ph)) return
						false;
					$aj = array();
					$ye = 0;
				}
				$aj[] = $Y;
				$ye += strlen($Y) + 2;
			}
			return
				queries($ng . implode(",\n", $aj) . $Ph);
		}

		function
		slowQuery($F, $ki) {
			if (min_version('5.7.8', '10.1.2')) {
				if (preg_match('~MariaDB~', $this->_conn->server_info)) return "SET STATEMENT max_statement_time=$ki FOR $F"; elseif (preg_match('~^(SELECT\b)(.+)~is', $F, $A)) return "$A[1] /*+ MAX_EXECUTION_TIME(" . ($ki * 1000) . ") */ $A[2]";
			}
		}

		function
		convertSearch($u, $X, $o) {
			return (preg_match('~char|text|enum|set~', $o["type"]) && !preg_match("~^utf8~", $o["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($u USING " . charset($this->_conn) . ")" : $u);
		}

		function
		warnings() {
			$G = $this->_conn->query("SHOW WARNINGS");
			if ($G && $G->num_rows) {
				ob_start();
				select($G);
				return
					ob_get_clean();
			}
		}

		function
		tableHelp($B) {
			$Fe = preg_match('~MariaDB~', $this->_conn->server_info);
			if (information_schema(DB)) return
				strtolower(($Fe ? "information-schema-$B-table/" : str_replace("_", "-", $B) . "-table.html"));
			if (DB == "mysql") return ($Fe ? "mysql$B-table/" : "system-database.html");
		}
	}

	function
	idf_escape($u) {
		return "`" . str_replace("`", "``", $u) . "`";
	}

	function
	table($u) {
		return
			idf_escape($u);
	}

	function
	connect() {
		global $b, $U, $Mh;
		$h = new
		Min_DB;
		$Kb = $b->credentials();
		if ($h->connect($Kb[0], $Kb[1], $Kb[2])) {
			$h->set_charset(charset($h));
			$h->query("SET sql_quote_show_create = 1, autocommit = 1");
			if (min_version('5.7.8', 10.2, $h)) {
				$Mh[lang(25)][] = "json";
				$U["json"] = 4294967295;
			}
			return $h;
		}
		$H = $h->error;
		if (function_exists('iconv') && !is_utf8($H) && strlen($dh = iconv("windows-1250", "utf-8", $H)) > strlen($H)) $H = $dh;
		return $H;
	}

	function
	get_databases($ed) {
		$H = get_session("dbs");
		if ($H === null) {
			$F = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
			$H = ($ed ? slow_query($F) : get_vals($F));
			restart_session();
			set_session("dbs", $H);
			stop_session();
		}
		return $H;
	}

	function
	limit($F, $Z, $z, $C = 0, $L = " ") {
		return " $F$Z" . ($z !== null ? $L . "LIMIT $z" . ($C ? " OFFSET $C" : "") : "");
	}

	function
	limit1($Q, $F, $Z, $L = "\n") {
		return
			limit($F, $Z, 1, 0, $L);
	}

	function
	db_collation($l, $qb) {
		global $h;
		$H = null;
		$Hb = $h->result("SHOW CREATE DATABASE " . idf_escape($l), 1);
		if (preg_match('~ COLLATE ([^ ]+)~', $Hb, $A)) $H = $A[1]; elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $Hb, $A)) $H = $qb[$A[1]][-1];
		return $H;
	}

	function
	engines() {
		$H = array();
		foreach (get_rows("SHOW ENGINES") as $I) {
			if (preg_match("~YES|DEFAULT~", $I["Support"])) $H[] = $I["Engine"];
		}
		return $H;
	}

	function
	logged_user() {
		global $h;
		return $h->result("SELECT USER()");
	}

	function
	tables_list() {
		return
			get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
	}

	function
	count_tables($k) {
		$H = array();
		foreach ($k
				 as $l) $H[$l] = count(get_vals("SHOW TABLES IN " . idf_escape($l)));
		return $H;
	}

	function
	table_status($B = "", $Sc = false) {
		$H = array();
		foreach (get_rows($Sc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($B != "" ? "AND TABLE_NAME = " . q($B) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($B != "" ? " LIKE " . q(addcslashes($B, "%_\\")) : "")) as $I) {
			if ($I["Engine"] == "InnoDB") $I["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $I["Comment"]);
			if (!isset($I["Engine"])) $I["Comment"] = "";
			if ($B != "") return $I;
			$H[$I["Name"]] = $I;
		}
		return $H;
	}

	function
	is_view($R) {
		return $R["Engine"] === null;
	}

	function
	fk_support($R) {
		return
			preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
	}

	function
	fields($Q) {
		$H = array();
		foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $I) {
			preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $I["Type"], $A);
			$H[$I["Field"]] = array("field" => $I["Field"], "full_type" => $I["Type"], "type" => $A[1], "length" => $A[2], "unsigned" => ltrim($A[3] . $A[4]), "default" => ($I["Default"] != "" || preg_match("~char|set~", $A[1]) ? $I["Default"] : null), "null" => ($I["Null"] == "YES"), "auto_increment" => ($I["Extra"] == "auto_increment"), "on_update" => (preg_match('~^on update (.+)~i', $I["Extra"], $A) ? $A[1] : ""), "collation" => $I["Collation"], "privileges" => array_flip(preg_split('~, *~', $I["Privileges"])), "comment" => $I["Comment"], "primary" => ($I["Key"] == "PRI"), "generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $I["Extra"]),);
		}
		return $H;
	}

	function
	indexes($Q, $i = null) {
		$H = array();
		foreach (get_rows("SHOW INDEX FROM " . table($Q), $i) as $I) {
			$B = $I["Key_name"];
			$H[$B]["type"] = ($B == "PRIMARY" ? "PRIMARY" : ($I["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($I["Non_unique"] ? ($I["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
			$H[$B]["columns"][] = $I["Column_name"];
			$H[$B]["lengths"][] = ($I["Index_type"] == "SPATIAL" ? null : $I["Sub_part"]);
			$H[$B]["descs"][] = null;
		}
		return $H;
	}

	function
	foreign_keys($Q) {
		global $h, $vf;
		static $fg = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
		$H = array();
		$Ib = $h->result("SHOW CREATE TABLE " . table($Q), 1);
		if ($Ib) {
			preg_match_all("~CONSTRAINT ($fg) FOREIGN KEY ?\\(((?:$fg,? ?)+)\\) REFERENCES ($fg)(?:\\.($fg))? \\(((?:$fg,? ?)+)\\)(?: ON DELETE ($vf))?(?: ON UPDATE ($vf))?~", $Ib, $Ie, PREG_SET_ORDER);
			foreach ($Ie
					 as $A) {
				preg_match_all("~$fg~", $A[2], $Ah);
				preg_match_all("~$fg~", $A[5], $ci);
				$H[idf_unescape($A[1])] = array("db" => idf_unescape($A[4] != "" ? $A[3] : $A[4]), "table" => idf_unescape($A[4] != "" ? $A[4] : $A[3]), "source" => array_map('idf_unescape', $Ah[0]), "target" => array_map('idf_unescape', $ci[0]), "on_delete" => ($A[6] ? $A[6] : "RESTRICT"), "on_update" => ($A[7] ? $A[7] : "RESTRICT"),);
			}
		}
		return $H;
	}

	function
	view($B) {
		global $h;
		return
			array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $h->result("SHOW CREATE VIEW " . table($B), 1)));
	}

	function
	collations() {
		$H = array();
		foreach (get_rows("SHOW COLLATION") as $I) {
			if ($I["Default"]) $H[$I["Charset"]][-1] = $I["Collation"]; else$H[$I["Charset"]][] = $I["Collation"];
		}
		ksort($H);
		foreach ($H
				 as $y => $X) asort($H[$y]);
		return $H;
	}

	function
	information_schema($l) {
		return (min_version(5) && $l == "information_schema") || (min_version(5.5) && $l == "performance_schema");
	}

	function
	error() {
		global $h;
		return
			h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $h->error));
	}

	function
	create_database($l, $d) {
		return
			queries("CREATE DATABASE " . idf_escape($l) . ($d ? " COLLATE " . q($d) : ""));
	}

	function
	drop_databases($k) {
		$H = apply_queries("DROP DATABASE", $k, 'idf_escape');
		restart_session();
		set_session("dbs", null);
		return $H;
	}

	function
	rename_database($B, $d) {
		$H = false;
		if (create_database($B, $d)) {
			$Pg = array();
			foreach (tables_list() as $Q => $T) $Pg[] = table($Q) . " TO " . idf_escape($B) . "." . table($Q);
			$H = (!$Pg || queries("RENAME TABLE " . implode(", ", $Pg)));
			if ($H) queries("DROP DATABASE " . idf_escape(DB));
			restart_session();
			set_session("dbs", null);
		}
		return $H;
	}

	function
	auto_increment() {
		$Oa = " PRIMARY KEY";
		if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
			foreach (indexes($_GET["create"]) as $v) {
				if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $v["columns"], true)) {
					$Oa = "";
					break;
				}
				if ($v["type"] == "PRIMARY") $Oa = " UNIQUE";
			}
		}
		return " AUTO_INCREMENT$Oa";
	}

	function
	alter_table($Q, $B, $p, $gd, $vb, $yc, $d, $Na, $Zf) {
		$c = array();
		foreach ($p
				 as $o) $c[] = ($o[1] ? ($Q != "" ? ($o[0] != "" ? "CHANGE " . idf_escape($o[0]) : "ADD") : " ") . " " . implode($o[1]) . ($Q != "" ? $o[2] : "") : "DROP " . idf_escape($o[0]));
		$c = array_merge($c, $gd);
		$O = ($vb !== null ? " COMMENT=" . q($vb) : "") . ($yc ? " ENGINE=" . q($yc) : "") . ($d ? " COLLATE " . q($d) : "") . ($Na != "" ? " AUTO_INCREMENT=$Na" : "");
		if ($Q == "") return
			queries("CREATE TABLE " . table($B) . " (\n" . implode(",\n", $c) . "\n)$O$Zf");
		if ($Q != $B) $c[] = "RENAME TO " . table($B);
		if ($O) $c[] = ltrim($O);
		return ($c || $Zf ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c) . $Zf) : true);
	}

	function
	alter_indexes($Q, $c) {
		foreach ($c
				 as $y => $X) $c[$y] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
		return
			queries("ALTER TABLE " . table($Q) . implode(",", $c));
	}

	function
	truncate_tables($S) {
		return
			apply_queries("TRUNCATE TABLE", $S);
	}

	function
	drop_views($fj) {
		return
			queries("DROP VIEW " . implode(", ", array_map('table', $fj)));
	}

	function
	drop_tables($S) {
		return
			queries("DROP TABLE " . implode(", ", array_map('table', $S)));
	}

	function
	move_tables($S, $fj, $ci) {
		$Pg = array();
		foreach (array_merge($S, $fj) as $Q) $Pg[] = table($Q) . " TO " . idf_escape($ci) . "." . table($Q);
		return
			queries("RENAME TABLE " . implode(", ", $Pg));
	}

	function
	copy_tables($S, $fj, $ci) {
		queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
		foreach ($S
				 as $Q) {
			$B = ($ci == DB ? table("copy_$Q") : idf_escape($ci) . "." . table($Q));
			if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $B")) || !queries("CREATE TABLE $B LIKE " . table($Q)) || !queries("INSERT INTO $B SELECT * FROM " . table($Q))) return
				false;
			foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $I) {
				$Bi = $I["Trigger"];
				if (!queries("CREATE TRIGGER " . ($ci == DB ? idf_escape("copy_$Bi") : idf_escape($ci) . "." . idf_escape($Bi)) . " $I[Timing] $I[Event] ON $B FOR EACH ROW\n$I[Statement];")) return
					false;
			}
		}
		foreach ($fj
				 as $Q) {
			$B = ($ci == DB ? table("copy_$Q") : idf_escape($ci) . "." . table($Q));
			$ej = view($Q);
			if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $B")) || !queries("CREATE VIEW $B AS $ej[select]")) return
				false;
		}
		return
			true;
	}

	function
	trigger($B) {
		if ($B == "") return
			array();
		$J = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($B));
		return
			reset($J);
	}

	function
	triggers($Q) {
		$H = array();
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $I) $H[$I["Trigger"]] = array($I["Timing"], $I["Event"]);
		return $H;
	}

	function
	trigger_options() {
		return
			array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW"),);
	}

	function
	routine($B, $T) {
		global $h, $_c, $Vd, $U;
		$Da = array("bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar");
		$Bh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
		$Gi = "((" . implode("|", array_merge(array_keys($U), $Da)) . ")\\b(?:\\s*\\(((?:[^'\")]|$_c)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
		$fg = "$Bh*(" . ($T == "FUNCTION" ? "" : $Vd) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Gi";
		$Hb = $h->result("SHOW CREATE $T " . idf_escape($B), 2);
		preg_match("~\\(((?:$fg\\s*,?)*)\\)\\s*" . ($T == "FUNCTION" ? "RETURNS\\s+$Gi\\s+" : "") . "(.*)~is", $Hb, $A);
		$p = array();
		preg_match_all("~$fg\\s*,?~is", $A[1], $Ie, PREG_SET_ORDER);
		foreach ($Ie
				 as $Sf) $p[] = array("field" => str_replace("``", "`", $Sf[2]) . $Sf[3], "type" => strtolower($Sf[5]), "length" => preg_replace_callback("~$_c~s", 'normalize_enum', $Sf[6]), "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Sf[8] $Sf[7]"))), "null" => 1, "full_type" => $Sf[4], "inout" => strtoupper($Sf[1]), "collation" => strtolower($Sf[9]),);
		if ($T != "FUNCTION") return
			array("fields" => $p, "definition" => $A[11]);
		return
			array("fields" => $p, "returns" => array("type" => $A[12], "length" => $A[13], "unsigned" => $A[15], "collation" => $A[16]), "definition" => $A[17], "language" => "SQL",);
	}

	function
	routines() {
		return
			get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
	}

	function
	routine_languages() {
		return
			array();
	}

	function
	routine_id($B, $I) {
		return
			idf_escape($B);
	}

	function
	last_id() {
		global $h;
		return $h->result("SELECT LAST_INSERT_ID()");
	}

	function
	explain($h, $F) {
		return $h->query("EXPLAIN " . (min_version(5.1) ? "PARTITIONS " : "") . $F);
	}

	function
	found_rows($R, $Z) {
		return ($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
	}

	function
	types() {
		return
			array();
	}

	function
	schemas() {
		return
			array();
	}

	function
	get_schema() {
		return "";
	}

	function
	set_schema($fh, $i = null) {
		return
			true;
	}

	function
	create_sql($Q, $Na, $Nh) {
		global $h;
		$H = $h->result("SHOW CREATE TABLE " . table($Q), 1);
		if (!$Na) $H = preg_replace('~ AUTO_INCREMENT=\d+~', '', $H);
		return $H;
	}

	function
	truncate_sql($Q) {
		return "TRUNCATE " . table($Q);
	}

	function
	use_sql($j) {
		return "USE " . idf_escape($j);
	}

	function
	trigger_sql($Q) {
		$H = "";
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")), null, "-- ") as $I) $H .= "\nCREATE TRIGGER " . idf_escape($I["Trigger"]) . " $I[Timing] $I[Event] ON " . table($I["Table"]) . " FOR EACH ROW\n$I[Statement];;\n";
		return $H;
	}

	function
	show_variables() {
		return
			get_key_vals("SHOW VARIABLES");
	}

	function
	process_list() {
		return
			get_rows("SHOW FULL PROCESSLIST");
	}

	function
	show_status() {
		return
			get_key_vals("SHOW STATUS");
	}

	function
	convert_field($o) {
		if (preg_match("~binary~", $o["type"])) return "HEX(" . idf_escape($o["field"]) . ")";
		if ($o["type"] == "bit") return "BIN(" . idf_escape($o["field"]) . " + 0)";
		if (preg_match("~geometry|point|linestring|polygon~", $o["type"])) return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($o["field"]) . ")";
	}

	function
	unconvert_field($o, $H) {
		if (preg_match("~binary~", $o["type"])) $H = "UNHEX($H)";
		if ($o["type"] == "bit") $H = "CONV($H, 2, 10) + 0";
		if (preg_match("~geometry|point|linestring|polygon~", $o["type"])) $H = (min_version(8) ? "ST_" : "") . "GeomFromText($H, SRID($o[field]))";
		return $H;
	}

	function
	support($Tc) {
		return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $Tc);
	}

	function
	kill_process($X) {
		return
			queries("KILL " . number($X));
	}

	function
	connection_id() {
		return "SELECT CONNECTION_ID()";
	}

	function
	max_connections() {
		global $h;
		return $h->result("SELECT @@max_connections");
	}

	$x = "sql";
	$U = array();
	$Mh = array();
	foreach (array(lang(27) => array("tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20, "decimal" => 66, "float" => 12, "double" => 21), lang(28) => array("date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4), lang(25) => array("char" => 255, "varchar" => 65535, "tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295), lang(33) => array("enum" => 65535, "set" => 64), lang(29) => array("bit" => 20, "binary" => 255, "varbinary" => 65535, "tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295), lang(31) => array("geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0, "multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0),) as $y => $X) {
		$U += $X;
		$Mh[$y] = array_keys($X);
	}
	$Ni = array("unsigned", "zerofill", "unsigned zerofill");
	$_f = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "REGEXP", "IN", "FIND_IN_SET", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL");
	$od = array("char_length", "date", "from_unixtime", "lower", "round", "floor", "ceil", "sec_to_time", "time_to_sec", "upper");
	$ud = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
	$qc = array(array("char" => "md5/sha1/password/encrypt/uuid", "binary" => "md5/sha1", "date|time" => "now",), array(number_type() => "+/-", "date" => "+ interval/- interval", "time" => "addtime/subtime", "char|text" => "concat",));
}
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", str_replace(":", "%3a", preg_replace('~\?.*~', '', relative_uri())) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ia = "4.7.7";

class
Adminer {
	var $operators;

	function
	name() {
		return "<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
	}

	function
	credentials() {
		return
			array(SERVER, $_GET["username"], get_password());
	}

	function
	connectSsl() {
	}

	function
	permanentLogin($Hb = false) {
		return
			password_file($Hb);
	}

	function
	bruteForceKey() {
		return $_SERVER["REMOTE_ADDR"];
	}

	function
	serverName($M) {
		return
			h($M);
	}

	function
	database() {
		return
			DB;
	}

	function
	databases($ed = true) {
		return
			get_databases($ed);
	}

	function
	schemas() {
		return
			schemas();
	}

	function
	queryTimeout() {
		return
			2;
	}

	function
	headers() {
	}

	function
	csp() {
		return
			csp();
	}

	function
	head() {
		return
			true;
	}

	function
	css() {
		$H = array();
		$Yc = "adminer.css";
		if (file_exists($Yc)) $H[] = "$Yc?v=" . crc32(file_get_contents($Yc));
		return $H;
	}

	function
	loginForm() {
		global $ic;
		echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('driver', '<tr><th>' . lang(34) . '<td>', html_select("auth[driver]", $ic, DRIVER, "loginDriver(this);") . "\n"), $this->loginFormField('server', '<tr><th>' . lang(35) . '<td>', '<input name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"), $this->loginFormField('username', '<tr><th>' . lang(36) . '<td>', '<input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")), $this->loginFormField('password', '<tr><th>' . lang(37) . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"), $this->loginFormField('db', '<tr><th>' . lang(38) . '<td>', '<input name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">' . "\n"), "</table>\n", "<p><input type='submit' value='" . lang(39) . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang(40)) . "\n";
	}

	function
	loginFormField($B, $Ad, $Y) {
		return $Ad . $Y;
	}

	function
	login($Ce, $E) {
		if ($E == "") return
			lang(41, target_blank());
		return
			true;
	}

	function
	tableName($Th) {
		return
			h($Th["Name"]);
	}

	function
	fieldName($o, $Ef = 0) {
		return '<span title="' . h($o["full_type"]) . '">' . h($o["field"]) . '</span>';
	}

	function
	selectLinks($Th, $N = "") {
		global $x, $m;
		echo '<p class="links">';
		$Ae = array("select" => lang(42));
		if (support("table") || support("indexes")) $Ae["table"] = lang(43);
		if (support("table")) {
			if (is_view($Th)) $Ae["view"] = lang(44); else$Ae["create"] = lang(45);
		}
		if ($N !== null) $Ae["edit"] = lang(46);
		$B = $Th["Name"];
		foreach ($Ae
				 as $y => $X) echo " <a href='" . h(ME) . "$y=" . urlencode($B) . ($y == "edit" ? $N : "") . "'" . bold(isset($_GET[$y])) . ">$X</a>";
		echo
		doc_link(array($x => $m->tableHelp($B)), "?"), "\n";
	}

	function
	foreignKeys($Q) {
		return
			foreign_keys($Q);
	}

	function
	backwardKeys($Q, $Sh) {
		return
			array();
	}

	function
	backwardKeysPrint($Qa, $I) {
	}

	function
	selectQuery($F, $Ih, $Rc = false) {
		global $x, $m;
		$H = "</p>\n";
		if (!$Rc && ($ij = $m->warnings())) {
			$t = "warnings";
			$H = ", <a href='#$t'>" . lang(47) . "</a>" . script("qsl('a').onclick = partial(toggle, '$t');", "") . "$H<div id='$t' class='hidden'>\n$ij</div>\n";
		}
		return "<p><code class='jush-$x'>" . h(str_replace("\n", " ", $F)) . "</code> <span class='time'>(" . format_time($Ih) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($F) . "'>" . lang(10) . "</a>" : "") . $H;
	}

	function
	sqlCommandQuery($F) {
		return
			shorten_utf8(trim($F), 1000);
	}

	function
	rowDescription($Q) {
		return "";
	}

	function
	rowDescriptions($J, $hd) {
		return $J;
	}

	function
	selectLink($X, $o) {
	}

	function
	selectVal($X, $_, $o, $Mf) {
		$H = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $o["type"]) && !preg_match("~var~", $o["type"]) ? "<code>$X</code>" : $X));
		if (preg_match('~blob|bytea|raw|file~', $o["type"]) && !is_utf8($X)) $H = "<i>" . lang(48, strlen($Mf)) . "</i>";
		if (preg_match('~json~', $o["type"])) $H = "<code class='jush-js'>$H</code>";
		return ($_ ? "<a href='" . h($_) . "'" . (is_url($_) ? target_blank() : "") . ">$H</a>" : $H);
	}

	function
	editVal($X, $o) {
		return $X;
	}

	function
	tableStructurePrint($p) {
		echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr><th>" . lang(49) . "<td>" . lang(50) . (support("comment") ? "<td>" . lang(51) : "") . "</thead>\n";
		foreach ($p
				 as $o) {
			echo "<tr" . odd() . "><th>" . h($o["field"]), "<td><span title='" . h($o["collation"]) . "'>" . h($o["full_type"]) . "</span>", ($o["null"] ? " <i>NULL</i>" : ""), ($o["auto_increment"] ? " <i>" . lang(52) . "</i>" : ""), (isset($o["default"]) ? " <span title='" . lang(53) . "'>[<b>" . h($o["default"]) . "</b>]</span>" : ""), (support("comment") ? "<td>" . h($o["comment"]) : ""), "\n";
		}
		echo "</table>\n", "</div>\n";
	}

	function
	tableIndexesPrint($w) {
		echo "<table cellspacing='0'>\n";
		foreach ($w
				 as $B => $v) {
			ksort($v["columns"]);
			$rg = array();
			foreach ($v["columns"] as $y => $X) $rg[] = "<i>" . h($X) . "</i>" . ($v["lengths"][$y] ? "(" . $v["lengths"][$y] . ")" : "") . ($v["descs"][$y] ? " DESC" : "");
			echo "<tr title='" . h($B) . "'><th>$v[type]<td>" . implode(", ", $rg) . "\n";
		}
		echo "</table>\n";
	}

	function
	selectColumnsPrint($K, $f) {
		global $od, $ud;
		print_fieldset("select", lang(54), $K);
		$s = 0;
		$K[""] = array();
		foreach ($K
				 as $y => $X) {
			$X = $_GET["columns"][$y];
			$e = select_input(" name='columns[$s][col]'", $f, $X["col"], ($y !== "" ? "selectFieldChange" : "selectAddRow"));
			echo "<div>" . ($od || $ud ? "<select name='columns[$s][fun]'>" . optionlist(array(-1 => "") + array_filter(array(lang(55) => $od, lang(56) => $ud)), $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($y !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($e)" : $e) . "</div>\n";
			$s++;
		}
		echo "</div></fieldset>\n";
	}

	function
	selectSearchPrint($Z, $f, $w) {
		print_fieldset("search", lang(57), $Z);
		foreach ($w
				 as $s => $v) {
			if ($v["type"] == "FULLTEXT") {
				echo "<div>(<i>" . implode("</i>, <i>", array_map('h', $v["columns"])) . "</i>) AGAINST", " <input type='search' name='fulltext[$s]' value='" . h($_GET["fulltext"][$s]) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), checkbox("boolean[$s]", 1, isset($_GET["boolean"][$s]), "BOOL"), "</div>\n";
			}
		}
		$cb = "this.parentNode.firstChild.onchange();";
		foreach (array_merge((array)$_GET["where"], array(array())) as $s => $X) {
			if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
				echo "<div>" . select_input(" name='where[$s][col]'", $f, $X["col"], ($X ? "selectFieldChange" : "selectAddRow"), "(" . lang(58) . ")"), html_select("where[$s][op]", $this->operators, $X["op"], $cb), "<input type='search' name='where[$s][val]' value='" . h($X["val"]) . "'>", script("mixin(qsl('input'), {oninput: function () { $cb }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""), "</div>\n";
			}
		}
		echo "</div></fieldset>\n";
	}

	function
	selectOrderPrint($Ef, $f, $w) {
		print_fieldset("sort", lang(59), $Ef);
		$s = 0;
		foreach ((array)$_GET["order"] as $y => $X) {
			if ($X != "") {
				echo "<div>" . select_input(" name='order[$s]'", $f, $X, "selectFieldChange"), checkbox("desc[$s]", 1, isset($_GET["desc"][$y]), lang(60)) . "</div>\n";
				$s++;
			}
		}
		echo "<div>" . select_input(" name='order[$s]'", $f, "", "selectAddRow"), checkbox("desc[$s]", 1, false, lang(60)) . "</div>\n", "</div></fieldset>\n";
	}

	function
	selectLimitPrint($z) {
		echo "<fieldset><legend>" . lang(61) . "</legend><div>";
		echo "<input type='number' name='limit' class='size' value='" . h($z) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), "</div></fieldset>\n";
	}

	function
	selectLengthPrint($ii) {
		if ($ii !== null) {
			echo "<fieldset><legend>" . lang(62) . "</legend><div>", "<input type='number' name='text_length' class='size' value='" . h($ii) . "'>", "</div></fieldset>\n";
		}
	}

	function
	selectActionPrint($w) {
		echo "<fieldset><legend>" . lang(63) . "</legend><div>", "<input type='submit' value='" . lang(54) . "'>", " <span id='noindex' title='" . lang(64) . "'></span>", "<script" . nonce() . ">\n", "var indexColumns = ";
		$f = array();
		foreach ($w
				 as $v) {
			$Ob = reset($v["columns"]);
			if ($v["type"] != "FULLTEXT" && $Ob) $f[$Ob] = 1;
		}
		$f[""] = 1;
		foreach ($f
				 as $y => $X) json_row($y);
		echo ";\n", "selectFieldChange.call(qs('#form')['select']);\n", "</script>\n", "</div></fieldset>\n";
	}

	function
	selectCommandPrint() {
		return !information_schema(DB);
	}

	function
	selectImportPrint() {
		return !information_schema(DB);
	}

	function
	selectEmailPrint($vc, $f) {
	}

	function
	selectColumnsProcess($f, $w) {
		global $od, $ud;
		$K = array();
		$rd = array();
		foreach ((array)$_GET["columns"] as $y => $X) {
			if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $od) || in_array($X["fun"], $ud)))) {
				$K[$y] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
				if (!in_array($X["fun"], $ud)) $rd[] = $K[$y];
			}
		}
		return
			array($K, $rd);
	}

	function
	selectSearchProcess($p, $w) {
		global $h, $m;
		$H = array();
		foreach ($w
				 as $s => $v) {
			if ($v["type"] == "FULLTEXT" && $_GET["fulltext"][$s] != "") $H[] = "MATCH (" . implode(", ", array_map('idf_escape', $v["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$s]) . (isset($_GET["boolean"][$s]) ? " IN BOOLEAN MODE" : "") . ")";
		}
		foreach ((array)$_GET["where"] as $y => $X) {
			if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
				$ng = "";
				$yb = " $X[op]";
				if (preg_match('~IN$~', $X["op"])) {
					$Ld = process_length($X["val"]);
					$yb .= " " . ($Ld != "" ? $Ld : "(NULL)");
				} elseif ($X["op"] == "SQL") $yb = " $X[val]";
                elseif ($X["op"] == "LIKE %%") $yb = " LIKE " . $this->processInput($p[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "ILIKE %%") $yb = " ILIKE " . $this->processInput($p[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "FIND_IN_SET") {
					$ng = "$X[op](" . q($X["val"]) . ", ";
					$yb = ")";
				} elseif (!preg_match('~NULL$~', $X["op"])) $yb .= " " . $this->processInput($p[$X["col"]], $X["val"]);
				if ($X["col"] != "") $H[] = $ng . $m->convertSearch(idf_escape($X["col"]), $X, $p[$X["col"]]) . $yb; else {
					$sb = array();
					foreach ($p
							 as $B => $o) {
						if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $o["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $o["type"]))) $sb[] = $ng . $m->convertSearch(idf_escape($B), $X, $o) . $yb;
					}
					$H[] = ($sb ? "(" . implode(" OR ", $sb) . ")" : "1 = 0");
				}
			}
		}
		return $H;
	}

	function
	selectOrderProcess($p, $w) {
		$H = array();
		foreach ((array)$_GET["order"] as $y => $X) {
			if ($X != "") $H[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$y]) ? " DESC" : "");
		}
		return $H;
	}

	function
	selectLimitProcess() {
		return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
	}

	function
	selectLengthProcess() {
		return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
	}

	function
	selectEmailProcess($Z, $hd) {
		return
			false;
	}

	function
	selectQueryBuild($K, $Z, $rd, $Ef, $z, $D) {
		return "";
	}

	function
	messageQuery($F, $ji, $Rc = false) {
		global $x, $m;
		restart_session();
		$Bd =& get_session("queries");
		if (!$Bd[$_GET["db"]]) $Bd[$_GET["db"]] = array();
		if (strlen($F) > 1e6) $F = preg_replace('~[\x80-\xFF]+$~', '', substr($F, 0, 1e6)) . "\n…";
		$Bd[$_GET["db"]][] = array($F, time(), $ji);
		$Fh = "sql-" . count($Bd[$_GET["db"]]);
		$H = "<a href='#$Fh' class='toggle'>" . lang(65) . "</a>\n";
		if (!$Rc && ($ij = $m->warnings())) {
			$t = "warnings-" . count($Bd[$_GET["db"]]);
			$H = "<a href='#$t' class='toggle'>" . lang(47) . "</a>, $H<div id='$t' class='hidden'>\n$ij</div>\n";
		}
		return " <span class='time'>" . @date("H:i:s") . "</span>" . " $H<div id='$Fh' class='hidden'><pre><code class='jush-$x'>" . shorten_utf8($F, 1000) . "</code></pre>" . ($ji ? " <span class='time'>($ji)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($Bd[$_GET["db"]]) - 1)) . '">' . lang(10) . '</a>' : '') . '</div>';
	}

	function
	editFunctions($o) {
		global $qc;
		$H = ($o["null"] ? "NULL/" : "");
		foreach ($qc
				 as $y => $od) {
			if (!$y || (!isset($_GET["call"]) && (isset($_GET["select"]) || where($_GET)))) {
				foreach ($od
						 as $fg => $X) {
					if (!$fg || preg_match("~$fg~", $o["type"])) $H .= "/$X";
				}
				if ($y && !preg_match('~set|blob|bytea|raw|file~', $o["type"])) $H .= "/SQL";
			}
		}
		if ($o["auto_increment"] && !isset($_GET["select"]) && !where($_GET)) $H = lang(52);
		return
			explode("/", $H);
	}

	function
	editInput($Q, $o, $Ka, $Y) {
		if ($o["type"] == "enum") return (isset($_GET["select"]) ? "<label><input type='radio'$Ka value='-1' checked><i>" . lang(8) . "</i></label> " : "") . ($o["null"] ? "<label><input type='radio'$Ka value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $Ka, $o, $Y, 0);
		return "";
	}

	function
	editHint($Q, $o, $Y) {
		return "";
	}

	function
	processInput($o, $Y, $r = "") {
		if ($r == "SQL") return $Y;
		$B = $o["field"];
		$H = q($Y);
		if (preg_match('~^(now|getdate|uuid)$~', $r)) $H = "$r()"; elseif (preg_match('~^current_(date|timestamp)$~', $r)) $H = $r;
        elseif (preg_match('~^([+-]|\|\|)$~', $r)) $H = idf_escape($B) . " $r $H";
        elseif (preg_match('~^[+-] interval$~', $r)) $H = idf_escape($B) . " $r " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $H);
        elseif (preg_match('~^(addtime|subtime|concat)$~', $r)) $H = "$r(" . idf_escape($B) . ", $H)";
        elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $r)) $H = "$r($H)";
		return
			unconvert_field($o, $H);
	}

	function
	dumpOutput() {
		$H = array('text' => lang(66), 'file' => lang(67));
		if (function_exists('gzencode')) $H['gz'] = 'gzip';
		return $H;
	}

	function
	dumpFormat() {
		return
			array('sql' => 'SQL', 'csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV');
	}

	function
	dumpDatabase($l) {
	}

	function
	dumpTable($Q, $Nh, $ee = 0) {
		if ($_POST["format"] != "sql") {
			echo "\xef\xbb\xbf";
			if ($Nh) dump_csv(array_keys(fields($Q)));
		} else {
			if ($ee == 2) {
				$p = array();
				foreach (fields($Q) as $B => $o) $p[] = idf_escape($B) . " $o[full_type]";
				$Hb = "CREATE TABLE " . table($Q) . " (" . implode(", ", $p) . ")";
			} else$Hb = create_sql($Q, $_POST["auto_increment"], $Nh);
			set_utf8mb4($Hb);
			if ($Nh && $Hb) {
				if ($Nh == "DROP+CREATE" || $ee == 1) echo "DROP " . ($ee == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
				if ($ee == 1) $Hb = remove_definer($Hb);
				echo "$Hb;\n\n";
			}
		}
	}

	function
	dumpData($Q, $Nh, $F) {
		global $h, $x;
		$Ke = ($x == "sqlite" ? 0 : 1048576);
		if ($Nh) {
			if ($_POST["format"] == "sql") {
				if ($Nh == "TRUNCATE+INSERT") echo
					truncate_sql($Q) . ";\n";
				$p = fields($Q);
			}
			$G = $h->query($F, 1);
			if ($G) {
				$Xd = "";
				$Za = "";
				$le = array();
				$Ph = "";
				$Uc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
				while ($I = $G->$Uc()) {
					if (!$le) {
						$aj = array();
						foreach ($I
								 as $X) {
							$o = $G->fetch_field();
							$le[] = $o->name;
							$y = idf_escape($o->name);
							$aj[] = "$y = VALUES($y)";
						}
						$Ph = ($Nh == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $aj) : "") . ";\n";
					}
					if ($_POST["format"] != "sql") {
						if ($Nh == "table") {
							dump_csv($le);
							$Nh = "INSERT";
						}
						dump_csv($I);
					} else {
						if (!$Xd) $Xd = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $le)) . ") VALUES";
						foreach ($I
								 as $y => $X) {
							$o = $p[$y];
							$I[$y] = ($X !== null ? unconvert_field($o, preg_match(number_type(), $o["type"]) && !preg_match('~\[~', $o["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
						}
						$dh = ($Ke ? "\n" : " ") . "(" . implode(",\t", $I) . ")";
						if (!$Za) $Za = $Xd . $dh; elseif (strlen($Za) + 4 + strlen($dh) + strlen($Ph) < $Ke) $Za .= ",$dh";
						else {
							echo $Za . $Ph;
							$Za = $Xd . $dh;
						}
					}
				}
				if ($Za) echo $Za . $Ph;
			} elseif ($_POST["format"] == "sql") echo "-- " . str_replace("\n", " ", $h->error) . "\n";
		}
	}

	function
	dumpFilename($Gd) {
		return
			friendly_url($Gd != "" ? $Gd : (SERVER != "" ? SERVER : "localhost"));
	}

	function
	dumpHeaders($Gd, $Ze = false) {
		$Pf = $_POST["output"];
		$Mc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Ze ? "tar" : "csv"));
		header("Content-Type: " . ($Pf == "gz" ? "application/x-gzip" : ($Mc == "tar" ? "application/x-tar" : ($Mc == "sql" || $Pf != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
		if ($Pf == "gz") ob_start('ob_gzencode', 1e6);
		return $Mc;
	}

	function
	importServerPath() {
		return "adminer.sql";
	}

	function
	homepage() {
		echo '<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">' . lang(68) . "</a>\n" : ""), (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? lang(69) : lang(70)) . "</a>\n" : ""), ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . lang(71) . "</a>\n" : ""), (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . lang(72) . "</a>\n" : "");
		return
			true;
	}

	function
	navigation($Ye) {
		global $ia, $x, $ic, $h;
		echo '<h1>
', $this->name(), ' <span class="version">', $ia, '</span>
<a href="https://www.adminer.org/#download"', target_blank(), ' id="version">', (version_compare($ia, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""), '</a>
</h1>
';
		if ($Ye == "auth") {
			$Pf = "";
			foreach ((array)$_SESSION["pwds"] as $cj => $rh) {
				foreach ($rh
						 as $M => $Xi) {
					foreach ($Xi
							 as $V => $E) {
						if ($E !== null) {
							$Ub = $_SESSION["db"][$cj][$M][$V];
							foreach (($Ub ? array_keys($Ub) : array("")) as $l) $Pf .= "<li><a href='" . h(auth_url($cj, $M, $V, $l)) . "'>($ic[$cj]) " . h($V . ($M != "" ? "@" . $this->serverName($M) : "") . ($l != "" ? " - $l" : "")) . "</a>\n";
						}
					}
				}
			}
			if ($Pf) echo "<ul id='logins'>\n$Pf</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
		} else {
			if ($_GET["ns"] !== "" && !$Ye && DB != "") {
				$h->select_db(DB);
				$S = table_status('', true);
			}
			echo
			script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.7.7");
			if (support("sql")) {
				echo '<script', nonce(), '>
';
				if ($S) {
					$Ae = array();
					foreach ($S
							 as $Q => $T) $Ae[] = preg_quote($Q, '/');
					echo "var jushLinks = { $x: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $Ae) . ")\\b/g ] };\n";
					foreach (array("bac", "bra", "sqlite_quo", "mssql_bra") as $X) echo "jushLinks.$X = jushLinks.$x;\n";
				}
				$qh = $h->server_info;
				echo 'bodyLoad(\'', (is_object($h) ? preg_replace('~^(\d\.?\d).*~s', '\1', $qh) : ""), '\'', (preg_match('~MariaDB~', $qh) ? ", true" : ""), ');
</script>
';
			}
			$this->databasesPrint($Ye);
			if (DB == "" || !$Ye) {
				echo "<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . lang(65) . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . lang(73) . "</a>\n" : "") . "";
				if (support("dump")) echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . lang(74) . "</a>\n";
			}
			if ($_GET["ns"] !== "" && !$Ye && DB != "") {
				echo '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . lang(75) . "</a>\n";
				if (!$S) echo "<p class='message'>" . lang(9) . "\n"; else$this->tablesPrint($S);
			}
		}
	}

	function
	databasesPrint($Ye) {
		global $b, $h;
		$k = $this->databases();
		if ($k && !in_array(DB, $k)) array_unshift($k, DB);
		echo '<form action="">
<p id="dbs">
';
		hidden_fields_get();
		$Sb = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
		echo "<span title='" . lang(76) . "'>" . lang(77) . "</span>: " . ($k ? "<select name='db'>" . optionlist(array("" => "") + $k, DB) . "</select>$Sb" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n"), "<input type='submit' value='" . lang(20) . "'" . ($k ? " class='hidden'" : "") . ">\n";
		if ($Ye != "db" && DB != "" && $h->select_db(DB)) {
			if (support("scheme")) {
				echo "<br>" . lang(78) . ": <select name='ns'>" . optionlist(array("" => "") + $b->schemas(), $_GET["ns"]) . "</select>$Sb";
				if ($_GET["ns"] != "") set_schema($_GET["ns"]);
			}
		}
		foreach (array("import", "sql", "schema", "dump", "privileges") as $X) {
			if (isset($_GET[$X])) {
				echo "<input type='hidden' name='$X' value=''>";
				break;
			}
		}
		echo "</p></form>\n";
	}

	function
	tablesPrint($S) {
		echo "<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
		foreach ($S
				 as $Q => $O) {
			$B = $this->tableName($O);
			if ($B != "") {
				echo '<li><a href="' . h(ME) . 'select=' . urlencode($Q) . '"' . bold($_GET["select"] == $Q || $_GET["edit"] == $Q, "select") . ">" . lang(79) . "</a> ", (support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array($_GET["table"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"])), (is_view($O) ? "view" : "structure")) . " title='" . lang(43) . "'>$B</a>" : "<span>$B</span>") . "\n";
			}
		}
		echo "</ul>\n";
	}
}

$b = (function_exists('adminer_object') ? adminer_object() : new
Adminer);
if ($b->operators === null) $b->operators = $_f;
function
page_header($mi, $n = "", $Ya = array(), $ni = "") {
	global $ca, $ia, $b, $ic, $x;
	page_headers();
	if (is_ajax() && $n) {
		page_messages($n);
		exit;
	}
	$oi = $mi . ($ni != "" ? ": $ni" : "");
	$pi = strip_tags($oi . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $b->name());
	echo '<!DOCTYPE html>
<html lang="', $ca, '" dir="', lang(80), '">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $pi, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.7.7"), '">
', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.7.7");
	if ($b->head()) {
		echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.7"), '">
<link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.7"), '">
';
		foreach ($b->css() as $Mb) {
			echo '<link rel="stylesheet" type="text/css" href="', h($Mb), '">
';
		}
	}
	echo '
<body class="', lang(80), ' nojs">
';
	$Yc = get_temp_dir() . "/adminer.version";
	if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($Yc) && filemtime($Yc) + 86400 > time()) {
		$dj = unserialize(file_get_contents($Yc));
		$yg = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
		if (openssl_verify($dj["version"], base64_decode($dj["signature"]), $yg) == 1) $_COOKIE["adminer_version"] = $dj["version"];
	}
	echo '<script', nonce(), '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ia', '" . js_escape(ME) . "', '" . get_token() . "')"); ?>});
    document.body.className = document.body.className.replace(/ nojs/, ' js');
    var offlineMessage = '<?php echo
	js_escape(lang(81)), '\';
var thousandsSeparator = \'', js_escape(lang(5)), '\';
</script>

<div id="help" class="jush-', $x, ' jsonly hidden"></div>
', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"), '
<div id="content">
';
	if ($Ya !== null) {
		$_ = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
		echo '<p id="breadcrumb"><a href="' . h($_ ? $_ : ".") . '">' . $ic[DRIVER] . '</a> &raquo; ';
		$_ = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
		$M = $b->serverName(SERVER);
		$M = ($M != "" ? $M : lang(35));
		if ($Ya === false) echo "$M\n"; else {
			echo "<a href='" . ($_ ? h($_) : ".") . "' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";
			if ($_GET["ns"] != "" || (DB != "" && is_array($Ya))) echo '<a href="' . h($_ . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
			if (is_array($Ya)) {
				if ($_GET["ns"] != "") echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
				foreach ($Ya
						 as $y => $X) {
					$bc = (is_array($X) ? $X[1] : h($X));
					if ($bc != "") echo "<a href='" . h(ME . "$y=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$bc</a> &raquo; ";
				}
			}
			echo "$mi\n";
		}
	}
	echo "<h2>$oi</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
	restart_session();
	page_messages($n);
	$k =& get_session("dbs");
	if (DB != "" && $k && !in_array(DB, $k, true)) $k = null;
	stop_session();
	define("PAGE_HEADER", 1);
}

function
page_headers() {
	global $b;
	header("Content-Type: text/html; charset=utf-8");
	header("Cache-Control: no-cache");
	header("X-Frame-Options: deny");
	header("X-XSS-Protection: 0");
	header("X-Content-Type-Options: nosniff");
	header("Referrer-Policy: origin-when-cross-origin");
	foreach ($b->csp() as $Lb) {
		$_d = array();
		foreach ($Lb
				 as $y => $X) $_d[] = "$y $X";
		header("Content-Security-Policy: " . implode("; ", $_d));
	}
	$b->headers();
}

function
csp() {
	return
		array(array("script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'", "connect-src" => "'self'", "frame-src" => "https://www.adminer.org", "object-src" => "'none'", "base-uri" => "'none'", "form-action" => "'self'",),);
}

function
get_nonce() {
	static $if;
	if (!$if) $if = base64_encode(rand_string());
	return $if;
}

function
page_messages($n) {
	$Pi = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
	$Ue = $_SESSION["messages"][$Pi];
	if ($Ue) {
		echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Ue) . "</div>" . script("messagesPrint();");
		unset($_SESSION["messages"][$Pi]);
	}
	if ($n) echo "<div class='error'>$n</div>\n";
}

function
page_footer($Ye = "") {
	global $b, $ti;
	echo '</div>

';
	switch_lang();
	if ($Ye != "auth") {
		echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="', lang(82), '" id="logout">
<input type="hidden" name="token" value="', $ti, '">
</p>
</form>
';
	}
	echo '<div id="menu">
';
	$b->navigation($Ye);
	echo '</div>
', script("setupSubmitHighlight(document);");
}

function
int32($bf) {
	while ($bf >= 2147483648) $bf -= 4294967296;
	while ($bf <= -2147483649) $bf += 4294967296;
	return (int)$bf;
}

function
long2str($W, $hj) {
	$dh = '';
	foreach ($W
			 as $X) $dh .= pack('V', $X);
	if ($hj) return
		substr($dh, 0, end($W));
	return $dh;
}

function
str2long($dh, $hj) {
	$W = array_values(unpack('V*', str_pad($dh, 4 * ceil(strlen($dh) / 4), "\0")));
	if ($hj) $W[] = strlen($dh);
	return $W;
}

function
xxtea_mx($uj, $tj, $Qh, $he) {
	return
		int32((($uj >> 5 & 0x7FFFFFF) ^ $tj << 2) + (($tj >> 3 & 0x1FFFFFFF) ^ $uj << 4)) ^ int32(($Qh ^ $tj) + ($he ^ $uj));
}

function
encrypt_string($Lh, $y) {
	if ($Lh == "") return "";
	$y = array_values(unpack("V*", pack("H*", md5($y))));
	$W = str2long($Lh, true);
	$bf = count($W) - 1;
	$uj = $W[$bf];
	$tj = $W[0];
	$zg = floor(6 + 52 / ($bf + 1));
	$Qh = 0;
	while ($zg-- > 0) {
		$Qh = int32($Qh + 0x9E3779B9);
		$pc = $Qh >> 2 & 3;
		for ($Qf = 0; $Qf < $bf; $Qf++) {
			$tj = $W[$Qf + 1];
			$af = xxtea_mx($uj, $tj, $Qh, $y[$Qf & 3 ^ $pc]);
			$uj = int32($W[$Qf] + $af);
			$W[$Qf] = $uj;
		}
		$tj = $W[0];
		$af = xxtea_mx($uj, $tj, $Qh, $y[$Qf & 3 ^ $pc]);
		$uj = int32($W[$bf] + $af);
		$W[$bf] = $uj;
	}
	return
		long2str($W, false);
}

function
decrypt_string($Lh, $y) {
	if ($Lh == "") return "";
	if (!$y) return
		false;
	$y = array_values(unpack("V*", pack("H*", md5($y))));
	$W = str2long($Lh, false);
	$bf = count($W) - 1;
	$uj = $W[$bf];
	$tj = $W[0];
	$zg = floor(6 + 52 / ($bf + 1));
	$Qh = int32($zg * 0x9E3779B9);
	while ($Qh) {
		$pc = $Qh >> 2 & 3;
		for ($Qf = $bf; $Qf > 0; $Qf--) {
			$uj = $W[$Qf - 1];
			$af = xxtea_mx($uj, $tj, $Qh, $y[$Qf & 3 ^ $pc]);
			$tj = int32($W[$Qf] - $af);
			$W[$Qf] = $tj;
		}
		$uj = $W[$bf];
		$af = xxtea_mx($uj, $tj, $Qh, $y[$Qf & 3 ^ $pc]);
		$tj = int32($W[0] - $af);
		$W[0] = $tj;
		$Qh = int32($Qh - 0x9E3779B9);
	}
	return
		long2str($W, true);
}

$h = '';
$zd = $_SESSION["token"];
if (!$zd) $_SESSION["token"] = rand(1, 1e6);
$ti = get_token();
$gg = array();
if ($_COOKIE["adminer_permanent"]) {
	foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
		list($y) = explode(":", $X);
		$gg[$y] = $X;
	}
}
function
add_invalid_login() {
	global $b;
	$md = file_open_lock(get_temp_dir() . "/adminer.invalid");
	if (!$md) return;
	$ae = unserialize(stream_get_contents($md));
	$ji = time();
	if ($ae) {
		foreach ($ae
				 as $be => $X) {
			if ($X[0] < $ji) unset($ae[$be]);
		}
	}
	$Zd =& $ae[$b->bruteForceKey()];
	if (!$Zd) $Zd = array($ji + 30 * 60, 0);
	$Zd[1]++;
	file_write_unlock($md, serialize($ae));
}

function
check_invalid_login() {
	global $b;
	$ae = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
	$Zd = $ae[$b->bruteForceKey()];
	$hf = ($Zd[1] > 29 ? $Zd[0] - time() : 0);
	if ($hf > 0) auth_error(lang(83, ceil($hf / 60)));
}

$La = $_POST["auth"];
if ($La) {
	session_regenerate_id();
	$cj = $La["driver"];
	$M = $La["server"];
	$V = $La["username"];
	$E = (string)$La["password"];
	$l = $La["db"];
	set_password($cj, $M, $V, $E);
	$_SESSION["db"][$cj][$M][$V][$l] = true;
	if ($La["permanent"]) {
		$y = base64_encode($cj) . "-" . base64_encode($M) . "-" . base64_encode($V) . "-" . base64_encode($l);
		$sg = $b->permanentLogin(true);
		$gg[$y] = "$y:" . base64_encode($sg ? encrypt_string($E, $sg) : "");
		cookie("adminer_permanent", implode(" ", $gg));
	}
	if (count($_POST) == 1 || DRIVER != $cj || SERVER != $M || $_GET["username"] !== $V || DB != $l) redirect(auth_url($cj, $M, $V, $l));
} elseif ($_POST["logout"]) {
	if ($zd && !verify_token()) {
		page_header(lang(82), lang(84));
		page_footer("db");
		exit;
	} else {
		foreach (array("pwds", "db", "dbs", "queries") as $y) set_session($y, null);
		unset_permanent();
		redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(85) . ' ' . lang(86));
	}
} elseif ($gg && !$_SESSION["pwds"]) {
	session_regenerate_id();
	$sg = $b->permanentLogin();
	foreach ($gg
			 as $y => $X) {
		list(, $kb) = explode(":", $X);
		list($cj, $M, $V, $l) = array_map('base64_decode', explode("-", $y));
		set_password($cj, $M, $V, decrypt_string(base64_decode($kb), $sg));
		$_SESSION["db"][$cj][$M][$V][$l] = true;
	}
}
function
unset_permanent() {
	global $gg;
	foreach ($gg
			 as $y => $X) {
		list($cj, $M, $V, $l) = array_map('base64_decode', explode("-", $y));
		if ($cj == DRIVER && $M == SERVER && $V == $_GET["username"] && $l == DB) unset($gg[$y]);
	}
	cookie("adminer_permanent", implode(" ", $gg));
}

function
auth_error($n) {
	global $b, $zd;
	$sh = session_name();
	if (isset($_GET["username"])) {
		header("HTTP/1.1 403 Forbidden");
		if (($_COOKIE[$sh] || $_GET[$sh]) && !$zd) $n = lang(87); else {
			restart_session();
			add_invalid_login();
			$E = get_password();
			if ($E !== null) {
				if ($E === false) $n .= '<br>' . lang(88, target_blank(), '<code>permanentLogin()</code>');
				set_password(DRIVER, SERVER, $_GET["username"], null);
			}
			unset_permanent();
		}
	}
	if (!$_COOKIE[$sh] && $_GET[$sh] && ini_bool("session.use_only_cookies")) $n = lang(89);
	$Tf = session_get_cookie_params();
	cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $Tf["lifetime"]);
	page_header(lang(39), $n, null);
	echo "<form action='' method='post'>\n", "<div>";
	if (hidden_fields($_POST, array("auth"))) echo "<p class='message'>" . lang(90) . "\n";
	echo "</div>\n";
	$b->loginForm();
	echo "</form>\n";
	page_footer("auth");
	exit;
}

if (isset($_GET["username"]) && !class_exists("Min_DB")) {
	unset($_SESSION["pwds"][DRIVER]);
	unset_permanent();
	page_header(lang(91), lang(92, implode(", ", $mg)), false);
	page_footer("auth");
	exit;
}
stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
	list($Ed, $ig) = explode(":", SERVER, 2);
	if (is_numeric($ig) && ($ig < 1024 || $ig > 65535)) auth_error(lang(93));
	check_invalid_login();
	$h = connect();
	$m = new
	Min_Driver($h);
}
$Ce = null;
if (!is_object($h) || ($Ce = $b->login($_GET["username"], get_password())) !== true) {
	$n = (is_string($h) ? h($h) : (is_string($Ce) ? $Ce : lang(94)));
	auth_error($n . (preg_match('~^ | $~', get_password()) ? '<br>' . lang(95) : ''));
}
if ($La && $_POST["token"]) $_POST["token"] = $ti;
$n = '';
if ($_POST) {
	if (!verify_token()) {
		$Ud = "max_input_vars";
		$Oe = ini_get($Ud);
		if (extension_loaded("suhosin")) {
			foreach (array("suhosin.request.max_vars", "suhosin.post.max_vars") as $y) {
				$X = ini_get($y);
				if ($X && (!$Oe || $X < $Oe)) {
					$Ud = $y;
					$Oe = $X;
				}
			}
		}
		$n = (!$_POST["token"] && $Oe ? lang(96, "'$Ud'") : lang(84) . ' ' . lang(97));
	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
	$n = lang(98, "'post_max_size'");
	if (isset($_GET["sql"])) $n .= ' ' . lang(99);
}
function
select($G, $i = null, $Hf = array(), $z = 0) {
	global $x;
	$Ae = array();
	$w = array();
	$f = array();
	$Va = array();
	$U = array();
	$H = array();
	odd('');
	for ($s = 0; (!$z || $s < $z) && ($I = $G->fetch_row()); $s++) {
		if (!$s) {
			echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr>";
			for ($ge = 0; $ge < count($I); $ge++) {
				$o = $G->fetch_field();
				$B = $o->name;
				$Gf = $o->orgtable;
				$Ff = $o->orgname;
				$H[$o->table] = $Gf;
				if ($Hf && $x == "sql") $Ae[$ge] = ($B == "table" ? "table=" : ($B == "possible_keys" ? "indexes=" : null)); elseif ($Gf != "") {
					if (!isset($w[$Gf])) {
						$w[$Gf] = array();
						foreach (indexes($Gf, $i) as $v) {
							if ($v["type"] == "PRIMARY") {
								$w[$Gf] = array_flip($v["columns"]);
								break;
							}
						}
						$f[$Gf] = $w[$Gf];
					}
					if (isset($f[$Gf][$Ff])) {
						unset($f[$Gf][$Ff]);
						$w[$Gf][$Ff] = $ge;
						$Ae[$ge] = $Gf;
					}
				}
				if ($o->charsetnr == 63) $Va[$ge] = true;
				$U[$ge] = $o->type;
				echo "<th" . ($Gf != "" || $o->name != $Ff ? " title='" . h(($Gf != "" ? "$Gf." : "") . $Ff) . "'" : "") . ">" . h($B) . ($Hf ? doc_link(array('sql' => "explain-output.html#explain_" . strtolower($B), 'mariadb' => "explain/#the-columns-in-explain-select",)) : "");
			}
			echo "</thead>\n";
		}
		echo "<tr" . odd() . ">";
		foreach ($I
				 as $y => $X) {
			if ($X === null) $X = "<i>NULL</i>"; elseif ($Va[$y] && !is_utf8($X)) $X = "<i>" . lang(48, strlen($X)) . "</i>";
			else {
				$X = h($X);
				if ($U[$y] == 254) $X = "<code>$X</code>";
			}
			if (isset($Ae[$y]) && !$f[$Ae[$y]]) {
				if ($Hf && $x == "sql") {
					$Q = $I[array_search("table=", $Ae)];
					$_ = $Ae[$y] . urlencode($Hf[$Q] != "" ? $Hf[$Q] : $Q);
				} else {
					$_ = "edit=" . urlencode($Ae[$y]);
					foreach ($w[$Ae[$y]] as $ob => $ge) $_ .= "&where" . urlencode("[" . bracket_escape($ob) . "]") . "=" . urlencode($I[$ge]);
				}
				$X = "<a href='" . h(ME . $_) . "'>$X</a>";
			}
			echo "<td>$X";
		}
	}
	echo ($s ? "</table>\n</div>" : "<p class='message'>" . lang(12)) . "\n";
	return $H;
}

function
referencable_primary($mh) {
	$H = array();
	foreach (table_status('', true) as $Uh => $Q) {
		if ($Uh != $mh && fk_support($Q)) {
			foreach (fields($Uh) as $o) {
				if ($o["primary"]) {
					if ($H[$Uh]) {
						unset($H[$Uh]);
						break;
					}
					$H[$Uh] = $o;
				}
			}
		}
	}
	return $H;
}

function
adminer_settings() {
	parse_str($_COOKIE["adminer_settings"], $uh);
	return $uh;
}

function
adminer_setting($y) {
	$uh = adminer_settings();
	return $uh[$y];
}

function
set_adminer_settings($uh) {
	return
		cookie("adminer_settings", http_build_query($uh + adminer_settings()));
}

function
textarea($B, $Y, $J = 10, $sb = 80) {
	global $x;
	echo "<textarea name='$B' rows='$J' cols='$sb' class='sqlarea jush-$x' spellcheck='false' wrap='off'>";
	if (is_array($Y)) {
		foreach ($Y
				 as $X) echo
			h($X[0]) . "\n\n\n";
	} else
		echo
		h($Y);
	echo "</textarea>";
}

function
edit_type($y, $o, $qb, $id = array(), $Pc = array()) {
	global $Mh, $U, $Ni, $vf;
	$T = $o["type"];
	echo '<td><select name="', h($y), '[type]" class="type" aria-labelledby="label-type">';
	if ($T && !isset($U[$T]) && !isset($id[$T]) && !in_array($T, $Pc)) $Pc[] = $T;
	if ($id) $Mh[lang(100)] = $id;
	echo
	optionlist(array_merge($Pc, $Mh), $T), '</select><td><input name="', h($y), '[length]" value="', h($o["length"]), '" size="3"', (!$o["length"] && preg_match('~var(char|binary)$~', $T) ? " class='required'" : "");
	echo ' aria-labelledby="label-length"><td class="options">', "<select name='" . h($y) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $T) ? "" : " class='hidden'") . '><option value="">(' . lang(101) . ')' . optionlist($qb, $o["collation"]) . '</select>', ($Ni ? "<select name='" . h($y) . "[unsigned]'" . (!$T || preg_match(number_type(), $T) ? "" : " class='hidden'") . '><option>' . optionlist($Ni, $o["unsigned"]) . '</select>' : ''), (isset($o['on_update']) ? "<select name='" . h($y) . "[on_update]'" . (preg_match('~timestamp|datetime~', $T) ? "" : " class='hidden'") . '>' . optionlist(array("" => "(" . lang(102) . ")", "CURRENT_TIMESTAMP"), (preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? "CURRENT_TIMESTAMP" : $o["on_update"])) . '</select>' : ''), ($id ? "<select name='" . h($y) . "[on_delete]'" . (preg_match("~`~", $T) ? "" : " class='hidden'") . "><option value=''>(" . lang(103) . ")" . optionlist(explode("|", $vf), $o["on_delete"]) . "</select> " : " ");
}

function
process_length($ye) {
	global $_c;
	return (preg_match("~^\\s*\\(?\\s*$_c(?:\\s*,\\s*$_c)*+\\s*\\)?\\s*\$~", $ye) && preg_match_all("~$_c~", $ye, $Ie) ? "(" . implode(",", $Ie[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $ye)));
}

function
process_type($o, $pb = "COLLATE") {
	global $Ni;
	return " $o[type]" . process_length($o["length"]) . (preg_match(number_type(), $o["type"]) && in_array($o["unsigned"], $Ni) ? " $o[unsigned]" : "") . (preg_match('~char|text|enum|set~', $o["type"]) && $o["collation"] ? " $pb " . q($o["collation"]) : "");
}

function
process_field($o, $Fi) {
	return
		array(idf_escape(trim($o["field"])), process_type($Fi), ($o["null"] ? " NULL" : " NOT NULL"), default_value($o), (preg_match('~timestamp|datetime~', $o["type"]) && $o["on_update"] ? " ON UPDATE $o[on_update]" : ""), (support("comment") && $o["comment"] != "" ? " COMMENT " . q($o["comment"]) : ""), ($o["auto_increment"] ? auto_increment() : null),);
}

function
default_value($o) {
	$Wb = $o["default"];
	return ($Wb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $o["type"]) || preg_match('~^(?![a-z])~i', $Wb) ? q($Wb) : $Wb));
}

function
type_class($T) {
	foreach (array('char' => 'text', 'date' => 'time|year', 'binary' => 'blob', 'enum' => 'set',) as $y => $X) {
		if (preg_match("~$y|$X~", $T)) return " class='$y'";
	}
}

function
edit_fields($p, $qb, $T = "TABLE", $id = array()) {
	global $Vd;
	$p = array_values($p);
	$Xb = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
	$wb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");
	echo '<thead><tr>
';
	if ($T == "PROCEDURE") {
		echo '<td>';
	}
	echo '<th id="label-name">', ($T == "TABLE" ? lang(104) : lang(105)), '<td id="label-type">', lang(50), '<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>', script("qs('#enum-edit').onblur = editingLengthBlur;"), '<td id="label-length">', lang(106), '<td>', lang(107);
	if ($T == "TABLE") {
		echo '<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="', lang(52), '">AI</acronym>', doc_link(array('sql' => "example-auto-increment.html", 'mariadb' => "auto_increment/", 'sqlite' => "autoinc.html", 'pgsql' => "datatype.html#DATATYPE-SERIAL", 'mssql' => "ms186775.aspx",)), '<td id="label-default"', $Xb, '>', lang(53), (support("comment") ? "<td id='label-comment'$wb>" . lang(51) : "");
	}
	echo '<td>', "<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($p)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . lang(108) . "'>" . script("row_count = " . count($p) . ";"), '</thead>
<tbody>
', script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
	foreach ($p
			 as $s => $o) {
		$s++;
		$If = $o[($_POST ? "orig" : "field")];
		$fc = (isset($_POST["add"][$s - 1]) || (isset($o["field"]) && !$_POST["drop_col"][$s])) && (support("drop_col") || $If == "");
		echo '<tr', ($fc ? "" : " style='display: none;'"), '>
', ($T == "PROCEDURE" ? "<td>" . html_select("fields[$s][inout]", explode("|", $Vd), $o["inout"]) : ""), '<th>';
		if ($fc) {
			echo '<input name="fields[', $s, '][field]" value="', h($o["field"]), '" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
		}
		echo '<input type="hidden" name="fields[', $s, '][orig]" value="', h($If), '">';
		edit_type("fields[$s]", $o, $qb, $id);
		if ($T == "TABLE") {
			echo '<td>', checkbox("fields[$s][null]", 1, $o["null"], "", "", "block", "label-null"), '<td><label class="block"><input type="radio" name="auto_increment_col" value="', $s, '"';
			if ($o["auto_increment"]) {
				echo ' checked';
			}
			echo ' aria-labelledby="label-ai"></label><td', $Xb, '>', checkbox("fields[$s][has_default]", 1, $o["has_default"], "", "", "", "label-default"), '<input name="fields[', $s, '][default]" value="', h($o["default"]), '" aria-labelledby="label-default">', (support("comment") ? "<td$wb><input name='fields[$s][comment]' value='" . h($o["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
		}
		echo "<td>", (support("move_col") ? "<input type='image' class='icon' name='add[$s]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . lang(108) . "'> " . "<input type='image' class='icon' name='up[$s]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=up.gif&version=4.7.7") . "' alt='↑' title='" . lang(109) . "'> " . "<input type='image' class='icon' name='down[$s]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=down.gif&version=4.7.7") . "' alt='↓' title='" . lang(110) . "'> " : ""), ($If == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$s]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.7.7") . "' alt='x' title='" . lang(111) . "'>" : "");
	}
}

function
process_fields(&$p) {
	$C = 0;
	if ($_POST["up"]) {
		$se = 0;
		foreach ($p
				 as $y => $o) {
			if (key($_POST["up"]) == $y) {
				unset($p[$y]);
				array_splice($p, $se, 0, array($o));
				break;
			}
			if (isset($o["field"])) $se = $C;
			$C++;
		}
	} elseif ($_POST["down"]) {
		$kd = false;
		foreach ($p
				 as $y => $o) {
			if (isset($o["field"]) && $kd) {
				unset($p[key($_POST["down"])]);
				array_splice($p, $C, 0, array($kd));
				break;
			}
			if (key($_POST["down"]) == $y) $kd = $o;
			$C++;
		}
	} elseif ($_POST["add"]) {
		$p = array_values($p);
		array_splice($p, key($_POST["add"]), 0, array(array()));
	} elseif (!$_POST["drop_col"]) return
		false;
	return
		true;
}

function
normalize_enum($A) {
	return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($A[0][0] . $A[0][0], $A[0][0], substr($A[0], 1, -1))), '\\')) . "'";
}

function
grant($pd, $ug, $f, $uf) {
	if (!$ug) return
		true;
	if ($ug == array("ALL PRIVILEGES", "GRANT OPTION")) return ($pd == "GRANT" ? queries("$pd ALL PRIVILEGES$uf WITH GRANT OPTION") : queries("$pd ALL PRIVILEGES$uf") && queries("$pd GRANT OPTION$uf"));
	return
		queries("$pd " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$f, ", $ug) . $f) . $uf);
}

function
drop_create($jc, $Hb, $kc, $gi, $mc, $Be, $Te, $Re, $Se, $rf, $ef) {
	if ($_POST["drop"]) query_redirect($jc, $Be, $Te); elseif ($rf == "") query_redirect($Hb, $Be, $Se);
    elseif ($rf != $ef) {
		$Jb = queries($Hb);
		queries_redirect($Be, $Re, $Jb && queries($jc));
		if ($Jb) queries($kc);
	} else
		queries_redirect($Be, $Re, queries($gi) && queries($mc) && queries($jc) && queries($Hb));
}

function
create_trigger($uf, $I) {
	global $x;
	$li = " $I[Timing] $I[Event]" . ($I["Event"] == "UPDATE OF" ? " " . idf_escape($I["Of"]) : "");
	return "CREATE TRIGGER " . idf_escape($I["Trigger"]) . ($x == "mssql" ? $uf . $li : $li . $uf) . rtrim(" $I[Type]\n$I[Statement]", ";") . ";";
}

function
create_routine($Zg, $I) {
	global $Vd, $x;
	$N = array();
	$p = (array)$I["fields"];
	ksort($p);
	foreach ($p
			 as $o) {
		if ($o["field"] != "") $N[] = (preg_match("~^($Vd)\$~", $o["inout"]) ? "$o[inout] " : "") . idf_escape($o["field"]) . process_type($o, "CHARACTER SET");
	}
	$Yb = rtrim("\n$I[definition]", ";");
	return "CREATE $Zg " . idf_escape(trim($I["name"])) . " (" . implode(", ", $N) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($I["returns"], "CHARACTER SET") : "") . ($I["language"] ? " LANGUAGE $I[language]" : "") . ($x == "pgsql" ? " AS " . q($Yb) : "$Yb;");
}

function
remove_definer($F) {
	return
		preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $F);
}

function
format_foreign_key($q) {
	global $vf;
	$l = $q["db"];
	$jf = $q["ns"];
	return " FOREIGN KEY (" . implode(", ", array_map('idf_escape', $q["source"])) . ") REFERENCES " . ($l != "" && $l != $_GET["db"] ? idf_escape($l) . "." : "") . ($jf != "" && $jf != $_GET["ns"] ? idf_escape($jf) . "." : "") . table($q["table"]) . " (" . implode(", ", array_map('idf_escape', $q["target"])) . ")" . (preg_match("~^($vf)\$~", $q["on_delete"]) ? " ON DELETE $q[on_delete]" : "") . (preg_match("~^($vf)\$~", $q["on_update"]) ? " ON UPDATE $q[on_update]" : "");
}

function
tar_file($Yc, $qi) {
	$H = pack("a100a8a8a8a12a12", $Yc, 644, 0, 0, decoct($qi->size), decoct(time()));
	$ib = 8 * 32;
	for ($s = 0; $s < strlen($H); $s++) $ib += ord($H[$s]);
	$H .= sprintf("%06o", $ib) . "\0 ";
	echo $H, str_repeat("\0", 512 - strlen($H));
	$qi->send();
	echo
	str_repeat("\0", 511 - ($qi->size + 511) % 512);
}

function
ini_bytes($Ud) {
	$X = ini_get($Ud);
	switch (strtolower(substr($X, -1))) {
		case'g':
			$X *= 1024;
		case'm':
			$X *= 1024;
		case'k':
			$X *= 1024;
	}
	return $X;
}

function
doc_link($eg, $hi = "<sup>?</sup>") {
	global $x, $h;
	$qh = $h->server_info;
	$dj = preg_replace('~^(\d\.?\d).*~s', '\1', $qh);
	$Si = array('sql' => "https://dev.mysql.com/doc/refman/$dj/en/", 'sqlite' => "https://www.sqlite.org/", 'pgsql' => "https://www.postgresql.org/docs/$dj/", 'mssql' => "https://msdn.microsoft.com/library/", 'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $qh) . "&id=",);
	if (preg_match('~MariaDB~', $qh)) {
		$Si['sql'] = "https://mariadb.com/kb/en/library/";
		$eg['sql'] = (isset($eg['mariadb']) ? $eg['mariadb'] : str_replace(".html", "/", $eg['sql']));
	}
	return ($eg[$x] ? "<a href='$Si[$x]$eg[$x]'" . target_blank() . ">$hi</a>" : "");
}

function
ob_gzencode($P) {
	return
		gzencode($P);
}

function
db_size($l) {
	global $h;
	if (!$h->select_db($l)) return "?";
	$H = 0;
	foreach (table_status() as $R) $H += $R["Data_length"] + $R["Index_length"];
	return
		format_number($H);
}

function
set_utf8mb4($Hb) {
	global $h;
	static $N = false;
	if (!$N && preg_match('~\butf8mb4~i', $Hb)) {
		$N = true;
		echo "SET NAMES " . charset($h) . ";\n\n";
	}
}

function
connect_error() {
	global $b, $h, $ti, $n, $ic;
	if (DB != "") {
		header("HTTP/1.1 404 Not Found");
		page_header(lang(38) . ": " . h(DB), lang(112), true);
	} else {
		if ($_POST["db"] && !$n) queries_redirect(substr(ME, 0, -1), lang(113), drop_databases($_POST["db"]));
		page_header(lang(114), $n, false);
		echo "<p class='links'>\n";
		foreach (array('database' => lang(115), 'privileges' => lang(72), 'processlist' => lang(116), 'variables' => lang(117), 'status' => lang(118),) as $y => $X) {
			if (support($y)) echo "<a href='" . h(ME) . "$y='>$X</a>\n";
		}
		echo "<p>" . lang(119, $ic[DRIVER], "<b>" . h($h->server_info) . "</b>", "<b>$h->extension</b>") . "\n", "<p>" . lang(120, "<b>" . h(logged_user()) . "</b>") . "\n";
		$k = $b->databases();
		if ($k) {
			$gh = support("scheme");
			$qb = collations();
			echo "<form action='' method='post'>\n", "<table cellspacing='0' class='checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), "<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . lang(38) . " - <a href='" . h(ME) . "refresh=1'>" . lang(121) . "</a>" . "<td>" . lang(122) . "<td>" . lang(123) . "<td>" . lang(124) . " - <a href='" . h(ME) . "dbsize=1'>" . lang(125) . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
			$k = ($_GET["dbsize"] ? count_tables($k) : array_flip($k));
			foreach ($k
					 as $l => $S) {
				$Yg = h(ME) . "db=" . urlencode($l);
				$t = h("Db-" . $l);
				echo "<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $l, in_array($l, (array)$_POST["db"]), "", "", "", $t) : ""), "<th><a href='$Yg' id='$t'>" . h($l) . "</a>";
				$d = h(db_collation($l, $qb));
				echo "<td>" . (support("database") ? "<a href='$Yg" . ($gh ? "&amp;ns=" : "") . "&amp;database=' title='" . lang(68) . "'>$d</a>" : $d), "<td align='right'><a href='$Yg&amp;schema=' id='tables-" . h($l) . "' title='" . lang(71) . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>", "<td align='right' id='size-" . h($l) . "'>" . ($_GET["dbsize"] ? db_size($l) : "?"), "\n";
			}
			echo "</table>\n", (support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . lang(126) . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . lang(127) . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : ""), "<input type='hidden' name='token' value='$ti'>\n", "</form>\n", script("tableCheck();");
		}
	}
	page_footer("db");
}

if (isset($_GET["status"])) $_GET["variables"] = $_GET["status"];
if (isset($_GET["import"])) $_GET["sql"] = $_GET["import"];
if (!(DB != "" ? $h->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
	if (DB != "" || $_GET["refresh"]) {
		restart_session();
		set_session("dbs", null);
	}
	connect_error();
	exit;
}
if (support("scheme") && DB != "" && $_GET["ns"] !== "") {
	if (!isset($_GET["ns"])) redirect(preg_replace('~ns=[^&]*&~', '', ME) . "ns=" . get_schema());
	if (!set_schema($_GET["ns"])) {
		header("HTTP/1.1 404 Not Found");
		page_header(lang(78) . ": " . h($_GET["ns"]), lang(128), true);
		page_footer("ns");
		exit;
	}
}
$vf = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";

class
TmpFile {
	var $handler;
	var $size;

	function
	__construct() {
		$this->handler = tmpfile();
	}

	function
	write($Cb) {
		$this->size += strlen($Cb);
		fwrite($this->handler, $Cb);
	}

	function
	send() {
		fseek($this->handler, 0);
		fpassthru($this->handler);
		fclose($this->handler);
	}
}

$_c = "'(?:''|[^'\\\\]|\\\\.)*'";
$Vd = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) $_GET["edit"] = $_GET["select"];
if (isset($_GET["callf"])) $_GET["call"] = $_GET["callf"];
if (isset($_GET["function"])) $_GET["procedure"] = $_GET["function"];
if (isset($_GET["download"])) {
	$a = $_GET["download"];
	$p = fields($a);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=" . friendly_url("$a-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
	$K = array(idf_escape($_GET["field"]));
	$G = $m->select($a, $K, array(where($_GET, $p)), $K);
	$I = ($G ? $G->fetch_row() : array());
	echo $m->value($I[0], $p[$_GET["field"]]);
	exit;
} elseif (isset($_GET["table"])) {
	$a = $_GET["table"];
	$p = fields($a);
	if (!$p) $n = error();
	$R = table_status1($a, true);
	$B = $b->tableName($R);
	page_header(($p && is_view($R) ? $R['Engine'] == 'materialized view' ? lang(129) : lang(130) : lang(131)) . ": " . ($B != "" ? $B : h($a)), $n);
	$b->selectLinks($R);
	$vb = $R["Comment"];
	if ($vb != "") echo "<p class='nowrap'>" . lang(51) . ": " . h($vb) . "\n";
	if ($p) $b->tableStructurePrint($p);
	if (!is_view($R)) {
		if (support("indexes")) {
			echo "<h3 id='indexes'>" . lang(132) . "</h3>\n";
			$w = indexes($a);
			if ($w) $b->tableIndexesPrint($w);
			echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($a) . '">' . lang(133) . "</a>\n";
		}
		if (fk_support($R)) {
			echo "<h3 id='foreign-keys'>" . lang(100) . "</h3>\n";
			$id = foreign_keys($a);
			if ($id) {
				echo "<table cellspacing='0'>\n", "<thead><tr><th>" . lang(134) . "<td>" . lang(135) . "<td>" . lang(103) . "<td>" . lang(102) . "<td></thead>\n";
				foreach ($id
						 as $B => $q) {
					echo "<tr title='" . h($B) . "'>", "<th><i>" . implode("</i>, <i>", array_map('h', $q["source"])) . "</i>", "<td><a href='" . h($q["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($q["db"]), ME) : ($q["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($q["ns"]), ME) : ME)) . "table=" . urlencode($q["table"]) . "'>" . ($q["db"] != "" ? "<b>" . h($q["db"]) . "</b>." : "") . ($q["ns"] != "" ? "<b>" . h($q["ns"]) . "</b>." : "") . h($q["table"]) . "</a>", "(<i>" . implode("</i>, <i>", array_map('h', $q["target"])) . "</i>)", "<td>" . h($q["on_delete"]) . "\n", "<td>" . h($q["on_update"]) . "\n", '<td><a href="' . h(ME . 'foreign=' . urlencode($a) . '&name=' . urlencode($B)) . '">' . lang(136) . '</a>';
				}
				echo "</table>\n";
			}
			echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($a) . '">' . lang(137) . "</a>\n";
		}
	}
	if (support(is_view($R) ? "view_trigger" : "trigger")) {
		echo "<h3 id='triggers'>" . lang(138) . "</h3>\n";
		$Ei = triggers($a);
		if ($Ei) {
			echo "<table cellspacing='0'>\n";
			foreach ($Ei
					 as $y => $X) echo "<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($y) . "<td><a href='" . h(ME . 'trigger=' . urlencode($a) . '&name=' . urlencode($y)) . "'>" . lang(136) . "</a>\n";
			echo "</table>\n";
		}
		echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($a) . '">' . lang(139) . "</a>\n";
	}
} elseif (isset($_GET["schema"])) {
	page_header(lang(71), "", array(), h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
	$Wh = array();
	$Xh = array();
	$ea = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB)]);
	preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Ie, PREG_SET_ORDER);
	foreach ($Ie
			 as $s => $A) {
		$Wh[$A[1]] = array($A[2], $A[3]);
		$Xh[] = "\n\t'" . js_escape($A[1]) . "': [ $A[2], $A[3] ]";
	}
	$ui = 0;
	$Sa = -1;
	$fh = array();
	$Kg = array();
	$we = array();
	foreach (table_status('', true) as $Q => $R) {
		if (is_view($R)) continue;
		$jg = 0;
		$fh[$Q]["fields"] = array();
		foreach (fields($Q) as $B => $o) {
			$jg += 1.25;
			$o["pos"] = $jg;
			$fh[$Q]["fields"][$B] = $o;
		}
		$fh[$Q]["pos"] = ($Wh[$Q] ? $Wh[$Q] : array($ui, 0));
		foreach ($b->foreignKeys($Q) as $X) {
			if (!$X["db"]) {
				$ue = $Sa;
				if ($Wh[$Q][1] || $Wh[$X["table"]][1]) $ue = min(floatval($Wh[$Q][1]), floatval($Wh[$X["table"]][1])) - 1; else$Sa -= .1;
				while ($we[(string)$ue]) $ue -= .0001;
				$fh[$Q]["references"][$X["table"]][(string)$ue] = array($X["source"], $X["target"]);
				$Kg[$X["table"]][$Q][(string)$ue] = $X["target"];
				$we[(string)$ue] = true;
			}
		}
		$ui = max($ui, $fh[$Q]["pos"][0] + 2.5 + $jg);
	}
	echo '<div id="schema" style="height: ', $ui, 'em;">
<script', nonce(), '>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {', implode(",", $Xh) . "\n", '};
var em = qs(\'#schema\').offsetHeight / ', $ui, ';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'', js_escape(DB), '\');
</script>
';
	foreach ($fh
			 as $B => $Q) {
		echo "<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>", '<a href="' . h(ME) . 'table=' . urlencode($B) . '"><b>' . h($B) . "</b></a>", script("qsl('div').onmousedown = schemaMousedown;");
		foreach ($Q["fields"] as $o) {
			$X = '<span' . type_class($o["type"]) . ' title="' . h($o["full_type"] . ($o["null"] ? " NULL" : '')) . '">' . h($o["field"]) . '</span>';
			echo "<br>" . ($o["primary"] ? "<i>$X</i>" : $X);
		}
		foreach ((array)$Q["references"] as $di => $Lg) {
			foreach ($Lg
					 as $ue => $Hg) {
				$ve = $ue - $Wh[$B][1];
				$s = 0;
				foreach ($Hg[0] as $Ah) echo "\n<div class='references' title='" . h($di) . "' id='refs$ue-" . ($s++) . "' style='left: $ve" . "em; top: " . $Q["fields"][$Ah]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$ve) . "em;'></div></div>";
			}
		}
		foreach ((array)$Kg[$B] as $di => $Lg) {
			foreach ($Lg
					 as $ue => $f) {
				$ve = $ue - $Wh[$B][1];
				$s = 0;
				foreach ($f
						 as $ci) echo "\n<div class='references' title='" . h($di) . "' id='refd$ue-" . ($s++) . "' style='left: $ve" . "em; top: " . $Q["fields"][$ci]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.7.7") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$ve) . "em;'></div></div>";
			}
		}
		echo "\n</div>\n";
	}
	foreach ($fh
			 as $B => $Q) {
		foreach ((array)$Q["references"] as $di => $Lg) {
			foreach ($Lg
					 as $ue => $Hg) {
				$Xe = $ui;
				$Me = -10;
				foreach ($Hg[0] as $y => $Ah) {
					$kg = $Q["pos"][0] + $Q["fields"][$Ah]["pos"];
					$lg = $fh[$di]["pos"][0] + $fh[$di]["fields"][$Hg[1][$y]]["pos"];
					$Xe = min($Xe, $kg, $lg);
					$Me = max($Me, $kg, $lg);
				}
				echo "<div class='references' id='refl$ue' style='left: $ue" . "em; top: $Xe" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Me - $Xe) . "em;'></div></div>\n";
			}
		}
	}
	echo '</div>
<p class="links"><a href="', h(ME . "schema=" . urlencode($ea)), '" id="schema-link">', lang(140), '</a>
';
} elseif (isset($_GET["dump"])) {
	$a = $_GET["dump"];
	if ($_POST && !$n) {
		$Fb = "";
		foreach (array("output", "format", "db_style", "routines", "events", "table_style", "auto_increment", "triggers", "data_style") as $y) $Fb .= "&$y=" . urlencode($_POST[$y]);
		cookie("adminer_export", substr($Fb, 1));
		$S = array_flip((array)$_POST["tables"]) + array_flip((array)$_POST["data"]);
		$Mc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == "" || count($S) > 1));
		$de = preg_match('~sql~', $_POST["format"]);
		if ($de) {
			echo "-- Adminer $ia " . $ic[DRIVER] . " dump\n\n";
			if ($x == "sql") {
				echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
				$h->query("SET time_zone = '+00:00';");
			}
		}
		$Nh = $_POST["db_style"];
		$k = array(DB);
		if (DB == "") {
			$k = $_POST["databases"];
			if (is_string($k)) $k = explode("\n", rtrim(str_replace("\r", "", $k), "\n"));
		}
		foreach ((array)$k
				 as $l) {
			$b->dumpDatabase($l);
			if ($h->select_db($l)) {
				if ($de && preg_match('~CREATE~', $Nh) && ($Hb = $h->result("SHOW CREATE DATABASE " . idf_escape($l), 1))) {
					set_utf8mb4($Hb);
					if ($Nh == "DROP+CREATE") echo "DROP DATABASE IF EXISTS " . idf_escape($l) . ";\n";
					echo "$Hb;\n";
				}
				if ($de) {
					if ($Nh) echo
						use_sql($l) . ";\n\n";
					$Of = "";
					if ($_POST["routines"]) {
						foreach (array("FUNCTION", "PROCEDURE") as $Zg) {
							foreach (get_rows("SHOW $Zg STATUS WHERE Db = " . q($l), null, "-- ") as $I) {
								$Hb = remove_definer($h->result("SHOW CREATE $Zg " . idf_escape($I["Name"]), 2));
								set_utf8mb4($Hb);
								$Of .= ($Nh != 'DROP+CREATE' ? "DROP $Zg IF EXISTS " . idf_escape($I["Name"]) . ";;\n" : "") . "$Hb;;\n\n";
							}
						}
					}
					if ($_POST["events"]) {
						foreach (get_rows("SHOW EVENTS", null, "-- ") as $I) {
							$Hb = remove_definer($h->result("SHOW CREATE EVENT " . idf_escape($I["Name"]), 3));
							set_utf8mb4($Hb);
							$Of .= ($Nh != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($I["Name"]) . ";;\n" : "") . "$Hb;;\n\n";
						}
					}
					if ($Of) echo "DELIMITER ;;\n\n$Of" . "DELIMITER ;\n\n";
				}
				if ($_POST["table_style"] || $_POST["data_style"]) {
					$fj = array();
					foreach (table_status('', true) as $B => $R) {
						$Q = (DB == "" || in_array($B, (array)$_POST["tables"]));
						$Pb = (DB == "" || in_array($B, (array)$_POST["data"]));
						if ($Q || $Pb) {
							if ($Mc == "tar") {
								$qi = new
								TmpFile;
								ob_start(array($qi, 'write'), 1e5);
							}
							$b->dumpTable($B, ($Q ? $_POST["table_style"] : ""), (is_view($R) ? 2 : 0));
							if (is_view($R)) $fj[] = $B; elseif ($Pb) {
								$p = fields($B);
								$b->dumpData($B, $_POST["data_style"], "SELECT *" . convert_fields($p, $p) . " FROM " . table($B));
							}
							if ($de && $_POST["triggers"] && $Q && ($Ei = trigger_sql($B))) echo "\nDELIMITER ;;\n$Ei\nDELIMITER ;\n";
							if ($Mc == "tar") {
								ob_end_flush();
								tar_file((DB != "" ? "" : "$l/") . "$B.csv", $qi);
							} elseif ($de) echo "\n";
						}
					}
					foreach ($fj
							 as $ej) $b->dumpTable($ej, $_POST["table_style"], 1);
					if ($Mc == "tar") echo
					pack("x512");
				}
			}
		}
		if ($de) echo "-- " . $h->result("SELECT NOW()") . "\n";
		exit;
	}
	page_header(lang(74), $n, ($_GET["export"] != "" ? array("table" => $_GET["export"]) : array()), h(DB));
	echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
';
	$Tb = array('', 'USE', 'DROP+CREATE', 'CREATE');
	$Yh = array('', 'DROP+CREATE', 'CREATE');
	$Qb = array('', 'TRUNCATE+INSERT', 'INSERT');
	if ($x == "sql") $Qb[] = 'INSERT+UPDATE';
	parse_str($_COOKIE["adminer_export"], $I);
	if (!$I) $I = array("output" => "text", "format" => "sql", "db_style" => (DB != "" ? "" : "CREATE"), "table_style" => "DROP+CREATE", "data_style" => "INSERT");
	if (!isset($I["events"])) {
		$I["routines"] = $I["events"] = ($_GET["dump"] == "");
		$I["triggers"] = $I["table_style"];
	}
	echo "<tr><th>" . lang(141) . "<td>" . html_select("output", $b->dumpOutput(), $I["output"], 0) . "\n";
	echo "<tr><th>" . lang(142) . "<td>" . html_select("format", $b->dumpFormat(), $I["format"], 0) . "\n";
	echo($x == "sqlite" ? "" : "<tr><th>" . lang(38) . "<td>" . html_select('db_style', $Tb, $I["db_style"]) . (support("routine") ? checkbox("routines", 1, $I["routines"], lang(143)) : "") . (support("event") ? checkbox("events", 1, $I["events"], lang(144)) : "")), "<tr><th>" . lang(123) . "<td>" . html_select('table_style', $Yh, $I["table_style"]) . checkbox("auto_increment", 1, $I["auto_increment"], lang(52)) . (support("trigger") ? checkbox("triggers", 1, $I["triggers"], lang(138)) : ""), "<tr><th>" . lang(145) . "<td>" . html_select('data_style', $Qb, $I["data_style"]), '</table>
<p><input type="submit" value="', lang(74), '">
<input type="hidden" name="token" value="', $ti, '">

<table cellspacing="0">
', script("qsl('table').onclick = dumpClick;");
	$og = array();
	if (DB != "") {
		$gb = ($a != "" ? "" : " checked");
		echo "<thead><tr>", "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$gb>" . lang(123) . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""), "<th style='text-align: right;'><label class='block'>" . lang(145) . "<input type='checkbox' id='check-data'$gb></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""), "</thead>\n";
		$fj = "";
		$Zh = tables_list();
		foreach ($Zh
				 as $B => $T) {
			$ng = preg_replace('~_.*~', '', $B);
			$gb = ($a == "" || $a == (substr($a, -1) == "%" ? "$ng%" : $B));
			$rg = "<tr><td>" . checkbox("tables[]", $B, $gb, $B, "", "block");
			if ($T !== null && !preg_match('~table~i', $T)) $fj .= "$rg\n"; else
				echo "$rg<td align='right'><label class='block'><span id='Rows-" . h($B) . "'></span>" . checkbox("data[]", $B, $gb) . "</label>\n";
			$og[$ng]++;
		}
		echo $fj;
		if ($Zh) echo
		script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
	} else {
		echo "<thead><tr><th style='text-align: left;'>", "<label class='block'><input type='checkbox' id='check-databases'" . ($a == "" ? " checked" : "") . ">" . lang(38) . "</label>", script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""), "</thead>\n";
		$k = $b->databases();
		if ($k) {
			foreach ($k
					 as $l) {
				if (!information_schema($l)) {
					$ng = preg_replace('~_.*~', '', $l);
					echo "<tr><td>" . checkbox("databases[]", $l, $a == "" || $a == "$ng%", $l, "", "block") . "\n";
					$og[$ng]++;
				}
			}
		} else
			echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
	}
	echo '</table>
</form>
';
	$ad = true;
	foreach ($og
			 as $y => $X) {
		if ($y != "" && $X > 1) {
			echo ($ad ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$y%") . "'>" . h($y) . "</a>";
			$ad = false;
		}
	}
} elseif (isset($_GET["privileges"])) {
	page_header(lang(72));
	echo '<p class="links"><a href="' . h(ME) . 'user=">' . lang(146) . "</a>";
	$G = $h->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
	$pd = $G;
	if (!$G) $G = $h->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
	echo "<form action=''><p>\n";
	hidden_fields_get();
	echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n", ($pd ? "" : "<input type='hidden' name='grant' value=''>\n"), "<table cellspacing='0'>\n", "<thead><tr><th>" . lang(36) . "<th>" . lang(35) . "<th></thead>\n";
	while ($I = $G->fetch_assoc()) echo '<tr' . odd() . '><td>' . h($I["User"]) . "<td>" . h($I["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($I["User"]) . '&host=' . urlencode($I["Host"])) . '">' . lang(10) . "</a>\n";
	if (!$pd || DB != "") echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . lang(10) . "'>\n";
	echo "</table>\n", "</form>\n";
} elseif (isset($_GET["sql"])) {
	if (!$n && $_POST["export"]) {
		dump_headers("sql");
		$b->dumpTable("", "");
		$b->dumpData("", "table", $_POST["query"]);
		exit;
	}
	restart_session();
	$Cd =& get_session("queries");
	$Bd =& $Cd[DB];
	if (!$n && $_POST["clear"]) {
		$Bd = array();
		redirect(remove_from_uri("history"));
	}
	page_header((isset($_GET["import"]) ? lang(73) : lang(65)), $n);
	if (!$n && $_POST) {
		$md = false;
		if (!isset($_GET["import"])) $F = $_POST["query"]; elseif ($_POST["webfile"]) {
			$Eh = $b->importServerPath();
			$md = @fopen((file_exists($Eh) ? $Eh : "compress.zlib://$Eh.gz"), "rb");
			$F = ($md ? fread($md, 1e6) : false);
		} else$F = get_file("sql_file", true);
		if (is_string($F)) {
			if (function_exists('memory_get_usage')) @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($F) + memory_get_usage() + 8e6));
			if ($F != "" && strlen($F) < 1e6) {
				$zg = $F . (preg_match("~;[ \t\r\n]*\$~", $F) ? "" : ";");
				if (!$Bd || reset(end($Bd)) != $zg) {
					restart_session();
					$Bd[] = array($zg, time());
					set_session("queries", $Cd);
					stop_session();
				}
			}
			$Bh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
			$ac = ";";
			$C = 0;
			$xc = true;
			$i = connect();
			if (is_object($i) && DB != "") {
				$i->select_db(DB);
				if ($_GET["ns"] != "") set_schema($_GET["ns"], $i);
			}
			$ub = 0;
			$Bc = array();
			$Vf = '[\'"' . ($x == "sql" ? '`#' : ($x == "sqlite" ? '`[' : ($x == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($x == "pgsql" ? '|\$[^$]*\$' : '');
			$vi = microtime(true);
			parse_str($_COOKIE["adminer_export"], $ya);
			$oc = $b->dumpFormat();
			unset($oc["sql"]);
			while ($F != "") {
				if (!$C && preg_match("~^$Bh*+DELIMITER\\s+(\\S+)~i", $F, $A)) {
					$ac = $A[1];
					$F = substr($F, strlen($A[0]));
				} else {
					preg_match('(' . preg_quote($ac) . "\\s*|$Vf)", $F, $A, PREG_OFFSET_CAPTURE, $C);
					list($kd, $jg) = $A[0];
					if (!$kd && $md && !feof($md)) $F .= fread($md, 1e5); else {
						if (!$kd && rtrim($F) == "") break;
						$C = $jg + strlen($kd);
						if ($kd && rtrim($kd) != $ac) {
							while (preg_match('(' . ($kd == '/*' ? '\*/' : ($kd == '[' ? ']' : (preg_match('~^-- |^#~', $kd) ? "\n" : preg_quote($kd) . "|\\\\."))) . '|$)s', $F, $A, PREG_OFFSET_CAPTURE, $C)) {
								$dh = $A[0][0];
								if (!$dh && $md && !feof($md)) $F .= fread($md, 1e5); else {
									$C = $A[0][1] + strlen($dh);
									if ($dh[0] != "\\") break;
								}
							}
						} else {
							$xc = false;
							$zg = substr($F, 0, $jg);
							$ub++;
							$rg = "<pre id='sql-$ub'><code class='jush-$x'>" . $b->sqlCommandQuery($zg) . "</code></pre>\n";
							if ($x == "sqlite" && preg_match("~^$Bh*+ATTACH\\b~i", $zg, $A)) {
								echo $rg, "<p class='error'>" . lang(147) . "\n";
								$Bc[] = " <a href='#sql-$ub'>$ub</a>";
								if ($_POST["error_stops"]) break;
							} else {
								if (!$_POST["only_errors"]) {
									echo $rg;
									ob_flush();
									flush();
								}
								$Ih = microtime(true);
								if ($h->multi_query($zg) && is_object($i) && preg_match("~^$Bh*+USE\\b~i", $zg)) $i->query($zg);
								do {
									$G = $h->store_result();
									if ($h->error) {
										echo($_POST["only_errors"] ? $rg : ""), "<p class='error'>" . lang(148) . ($h->errno ? " ($h->errno)" : "") . ": " . error() . "\n";
										$Bc[] = " <a href='#sql-$ub'>$ub</a>";
										if ($_POST["error_stops"]) break
										2;
									} else {
										$ji = " <span class='time'>(" . format_time($Ih) . ")</span>" . (strlen($zg) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($zg)) . "'>" . lang(10) . "</a>" : "");
										$_a = $h->affected_rows;
										$ij = ($_POST["only_errors"] ? "" : $m->warnings());
										$jj = "warnings-$ub";
										if ($ij) $ji .= ", <a href='#$jj'>" . lang(47) . "</a>" . script("qsl('a').onclick = partial(toggle, '$jj');", "");
										$Jc = null;
										$Kc = "explain-$ub";
										if (is_object($G)) {
											$z = $_POST["limit"];
											$Hf = select($G, $i, array(), $z);
											if (!$_POST["only_errors"]) {
												echo "<form action='' method='post'>\n";
												$lf = $G->num_rows;
												echo "<p>" . ($lf ? ($z && $lf > $z ? lang(149, $z) : "") . lang(150, $lf) : ""), $ji;
												if ($i && preg_match("~^($Bh|\\()*+SELECT\\b~i", $zg) && ($Jc = explain($i, $zg))) echo ", <a href='#$Kc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$Kc');", "");
												$t = "export-$ub";
												echo ", <a href='#$t'>" . lang(74) . "</a>" . script("qsl('a').onclick = partial(toggle, '$t');", "") . "<span id='$t' class='hidden'>: " . html_select("output", $b->dumpOutput(), $ya["output"]) . " " . html_select("format", $oc, $ya["format"]) . "<input type='hidden' name='query' value='" . h($zg) . "'>" . " <input type='submit' name='export' value='" . lang(74) . "'><input type='hidden' name='token' value='$ti'></span>\n" . "</form>\n";
											}
										} else {
											if (preg_match("~^$Bh*+(CREATE|DROP|ALTER)$Bh++(DATABASE|SCHEMA)\\b~i", $zg)) {
												restart_session();
												set_session("dbs", null);
												stop_session();
											}
											if (!$_POST["only_errors"]) echo "<p class='message' title='" . h($h->info) . "'>" . lang(151, $_a) . "$ji\n";
										}
										echo($ij ? "<div id='$jj' class='hidden'>\n$ij</div>\n" : "");
										if ($Jc) {
											echo "<div id='$Kc' class='hidden'>\n";
											select($Jc, $i, $Hf);
											echo "</div>\n";
										}
									}
									$Ih = microtime(true);
								} while ($h->next_result());
							}
							$F = substr($F, $C);
							$C = 0;
						}
					}
				}
			}
			if ($xc) echo "<p class='message'>" . lang(152) . "\n"; elseif ($_POST["only_errors"]) {
				echo "<p class='message'>" . lang(153, $ub - count($Bc)), " <span class='time'>(" . format_time($vi) . ")</span>\n";
			} elseif ($Bc && $ub > 1) echo "<p class='error'>" . lang(148) . ": " . implode("", $Bc) . "\n";
		} else
			echo "<p class='error'>" . upload_error($F) . "\n";
	}
	echo '
<form action="" method="post" enctype="multipart/form-data" id="form">
';
	$Gc = "<input type='submit' value='" . lang(154) . "' title='Ctrl+Enter'>";
	if (!isset($_GET["import"])) {
		$zg = $_GET["sql"];
		if ($_POST) $zg = $_POST["query"]; elseif ($_GET["history"] == "all") $zg = $Bd;
        elseif ($_GET["history"] != "") $zg = $Bd[$_GET["history"]][0];
		echo "<p>";
		textarea("query", $zg, 20);
		echo
		script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . remove_from_uri("sql|limit|error_stops|only_errors") . "');"), "<p>$Gc\n", lang(155) . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
	} else {
		echo "<fieldset><legend>" . lang(156) . "</legend><div>";
		$vd = (extension_loaded("zlib") ? "[.gz]" : "");
		echo(ini_bool("file_uploads") ? "SQL$vd (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$Gc" : lang(157)), "</div></fieldset>\n";
		$Kd = $b->importServerPath();
		if ($Kd) {
			echo "<fieldset><legend>" . lang(158) . "</legend><div>", lang(159, "<code>" . h($Kd) . "$vd</code>"), ' <input type="submit" name="webfile" value="' . lang(160) . '">', "</div></fieldset>\n";
		}
		echo "<p>";
	}
	echo
		checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"])), lang(161)) . "\n", checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"])), lang(162)) . "\n", "<input type='hidden' name='token' value='$ti'>\n";
	if (!isset($_GET["import"]) && $Bd) {
		print_fieldset("history", lang(163), $_GET["history"] != "");
		for ($X = end($Bd); $X; $X = prev($Bd)) {
			$y = key($Bd);
			list($zg, $ji, $sc) = $X;
			echo '<a href="' . h(ME . "sql=&history=$y") . '">' . lang(10) . "</a>" . " <span class='time' title='" . @date('Y-m-d', $ji) . "'>" . @date("H:i:s", $ji) . "</span>" . " <code class='jush-$x'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $zg)))), 80, "</code>") . ($sc ? " <span class='time'>($sc)</span>" : "") . "<br>\n";
		}
		echo "<input type='submit' name='clear' value='" . lang(164) . "'>\n", "<a href='" . h(ME . "sql=&history=all") . "'>" . lang(165) . "</a>\n", "</div></fieldset>\n";
	}
	echo '</form>
';
} elseif (isset($_GET["edit"])) {
	$a = $_GET["edit"];
	$p = fields($a);
	$Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $p) : "") : where($_GET, $p));
	$Oi = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
	foreach ($p
			 as $B => $o) {
		if (!isset($o["privileges"][$Oi ? "update" : "insert"]) || $b->fieldName($o) == "" || $o["generated"]) unset($p[$B]);
	}
	if ($_POST && !$n && !isset($_GET["select"])) {
		$Be = $_POST["referer"];
		if ($_POST["insert"]) $Be = ($Oi ? null : $_SERVER["REQUEST_URI"]); elseif (!preg_match('~^.+&select=.+$~', $Be)) $Be = ME . "select=" . urlencode($a);
		$w = indexes($a);
		$Ji = unique_array($_GET["where"], $w);
		$Bg = "\nWHERE $Z";
		if (isset($_POST["delete"])) queries_redirect($Be, lang(166), $m->delete($a, $Bg, !$Ji)); else {
			$N = array();
			foreach ($p
					 as $B => $o) {
				$X = process_input($o);
				if ($X !== false && $X !== null) $N[idf_escape($B)] = $X;
			}
			if ($Oi) {
				if (!$N) redirect($Be);
				queries_redirect($Be, lang(167), $m->update($a, $N, $Bg, !$Ji));
				if (is_ajax()) {
					page_headers();
					page_messages($n);
					exit;
				}
			} else {
				$G = $m->insert($a, $N);
				$te = ($G ? last_id() : 0);
				queries_redirect($Be, lang(168, ($te ? " $te" : "")), $G);
			}
		}
	}
	$I = null;
	if ($_POST["save"]) $I = (array)$_POST["fields"]; elseif ($Z) {
		$K = array();
		foreach ($p
				 as $B => $o) {
			if (isset($o["privileges"]["select"])) {
				$Ha = convert_field($o);
				if ($_POST["clone"] && $o["auto_increment"]) $Ha = "''";
				if ($x == "sql" && preg_match("~enum|set~", $o["type"])) $Ha = "1*" . idf_escape($B);
				$K[] = ($Ha ? "$Ha AS " : "") . idf_escape($B);
			}
		}
		$I = array();
		if (!support("table")) $K = array("*");
		if ($K) {
			$G = $m->select($a, $K, array($Z), $K, array(), (isset($_GET["select"]) ? 2 : 1));
			if (!$G) $n = error(); else {
				$I = $G->fetch_assoc();
				if (!$I) $I = false;
			}
			if (isset($_GET["select"]) && (!$I || $G->fetch_assoc())) $I = null;
		}
	}
	if (!support("table") && !$p) {
		if (!$Z) {
			$G = $m->select($a, array("*"), $Z, array("*"));
			$I = ($G ? $G->fetch_assoc() : false);
			if (!$I) $I = array($m->primary => "");
		}
		if ($I) {
			foreach ($I
					 as $y => $X) {
				if (!$Z) $I[$y] = null;
				$p[$y] = array("field" => $y, "null" => ($y != $m->primary), "auto_increment" => ($y == $m->primary));
			}
		}
	}
	edit_form($a, $p, $I, $Oi);
} elseif (isset($_GET["create"])) {
	$a = $_GET["create"];
	$Xf = array();
	foreach (array('HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST') as $y) $Xf[$y] = $y;
	$Jg = referencable_primary($a);
	$id = array();
	foreach ($Jg
			 as $Uh => $o) $id[str_replace("`", "``", $Uh) . "`" . str_replace("`", "``", $o["field"])] = $Uh;
	$Kf = array();
	$R = array();
	if ($a != "") {
		$Kf = fields($a);
		$R = table_status($a);
		if (!$R) $n = lang(9);
	}
	$I = $_POST;
	$I["fields"] = (array)$I["fields"];
	if ($I["auto_increment_col"]) $I["fields"][$I["auto_increment_col"]]["auto_increment"] = true;
	if ($_POST) set_adminer_settings(array("comments" => $_POST["comments"], "defaults" => $_POST["defaults"]));
	if ($_POST && !process_fields($I["fields"]) && !$n) {
		if ($_POST["drop"]) queries_redirect(substr(ME, 0, -1), lang(169), drop_tables(array($a))); else {
			$p = array();
			$Ea = array();
			$Ti = false;
			$gd = array();
			$Jf = reset($Kf);
			$Ba = " FIRST";
			foreach ($I["fields"] as $y => $o) {
				$q = $id[$o["type"]];
				$Fi = ($q !== null ? $Jg[$q] : $o);
				if ($o["field"] != "") {
					if (!$o["has_default"]) $o["default"] = null;
					if ($y == $I["auto_increment_col"]) $o["auto_increment"] = true;
					$wg = process_field($o, $Fi);
					$Ea[] = array($o["orig"], $wg, $Ba);
					if ($wg != process_field($Jf, $Jf)) {
						$p[] = array($o["orig"], $wg, $Ba);
						if ($o["orig"] != "" || $Ba) $Ti = true;
					}
					if ($q !== null) $gd[idf_escape($o["field"])] = ($a != "" && $x != "sqlite" ? "ADD" : " ") . format_foreign_key(array('table' => $id[$o["type"]], 'source' => array($o["field"]), 'target' => array($Fi["field"]), 'on_delete' => $o["on_delete"],));
					$Ba = " AFTER " . idf_escape($o["field"]);
				} elseif ($o["orig"] != "") {
					$Ti = true;
					$p[] = array($o["orig"]);
				}
				if ($o["orig"] != "") {
					$Jf = next($Kf);
					if (!$Jf) $Ba = "";
				}
			}
			$Zf = "";
			if ($Xf[$I["partition_by"]]) {
				$ag = array();
				if ($I["partition_by"] == 'RANGE' || $I["partition_by"] == 'LIST') {
					foreach (array_filter($I["partition_names"]) as $y => $X) {
						$Y = $I["partition_values"][$y];
						$ag[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($I["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
					}
				}
				$Zf .= "\nPARTITION BY $I[partition_by]($I[partition])" . ($ag ? " (" . implode(",", $ag) . "\n)" : ($I["partitions"] ? " PARTITIONS " . (+$I["partitions"]) : ""));
			} elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"])) $Zf .= "\nREMOVE PARTITIONING";
			$Qe = lang(170);
			if ($a == "") {
				cookie("adminer_engine", $I["Engine"]);
				$Qe = lang(171);
			}
			$B = trim($I["name"]);
			queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($B), $Qe, alter_table($a, $B, ($x == "sqlite" && ($Ti || $gd) ? $Ea : $p), $gd, ($I["Comment"] != $R["Comment"] ? $I["Comment"] : null), ($I["Engine"] && $I["Engine"] != $R["Engine"] ? $I["Engine"] : ""), ($I["Collation"] && $I["Collation"] != $R["Collation"] ? $I["Collation"] : ""), ($I["Auto_increment"] != "" ? number($I["Auto_increment"]) : ""), $Zf));
		}
	}
	page_header(($a != "" ? lang(45) : lang(75)), $n, array("table" => $a), h($a));
	if (!$_POST) {
		$I = array("Engine" => $_COOKIE["adminer_engine"], "fields" => array(array("field" => "", "type" => (isset($U["int"]) ? "int" : (isset($U["integer"]) ? "integer" : "")), "on_update" => "")), "partition_names" => array(""),);
		if ($a != "") {
			$I = $R;
			$I["name"] = $a;
			$I["fields"] = array();
			if (!$_GET["auto_increment"]) $I["Auto_increment"] = "";
			foreach ($Kf
					 as $o) {
				$o["has_default"] = isset($o["default"]);
				$I["fields"][] = $o;
			}
			if (support("partitioning")) {
				$nd = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($a);
				$G = $h->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $nd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
				list($I["partition_by"], $I["partitions"], $I["partition"]) = $G->fetch_row();
				$ag = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $nd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
				$ag[""] = "";
				$I["partition_names"] = array_keys($ag);
				$I["partition_values"] = array_values($ag);
			}
		}
	}
	$qb = collations();
	$zc = engines();
	foreach ($zc
			 as $yc) {
		if (!strcasecmp($yc, $I["Engine"])) {
			$I["Engine"] = $yc;
			break;
		}
	}
	echo '
<form action="" method="post" id="form">
<p>
';
	if (support("columns") || $a == "") {
		echo
		lang(172), ': <input name="name" data-maxlength="64" value="', h($I["name"]), '" autocapitalize="off">
';
		if ($a == "" && !$_POST) echo
		script("focus(qs('#form')['name']);");
		echo($zc ? "<select name='Engine'>" . optionlist(array("" => "(" . lang(173) . ")") + $zc, $I["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : ""), ' ', ($qb && !preg_match("~sqlite|mssql~", $x) ? html_select("Collation", array("" => "(" . lang(101) . ")") + $qb, $I["Collation"]) : ""), ' <input type="submit" value="', lang(14), '">
';
	}
	echo '
';
	if (support("columns")) {
		echo '<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
		edit_fields($I["fields"], $qb, "TABLE", $id);
		echo '</table>
', script("editFields();"), '</div>
<p>
', lang(52), ': <input type="number" name="Auto_increment" size="6" value="', h($I["Auto_increment"]), '">
', checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")), lang(174), "columnShow(this.checked, 5)", "jsonly"), (support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")), lang(51), "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($I["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : ''), '<p>
<input type="submit" value="', lang(14), '">
';
	}
	echo '
';
	if ($a != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $a));
	}
	if (support("partitioning")) {
		$Yf = preg_match('~RANGE|LIST~', $I["partition_by"]);
		print_fieldset("partition", lang(176), $I["partition_by"]);
		echo '<p>
', "<select name='partition_by'>" . optionlist(array("" => "") + $Xf, $I["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;"), '(<input name="partition" value="', h($I["partition"]), '">)
', lang(177), ': <input type="number" name="partitions" class="size', ($Yf || !$I["partition_by"] ? " hidden" : ""), '" value="', h($I["partitions"]), '">
<table cellspacing="0" id="partition-table"', ($Yf ? "" : " class='hidden'"), '>
<thead><tr><th>', lang(178), '<th>', lang(179), '</thead>
';
		foreach ($I["partition_names"] as $y => $X) {
			echo '<tr>', '<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">', ($y == count($I["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''), '<td><input name="partition_values[]" value="' . h($I["partition_values"][$y]) . '">';
		}
		echo '</table>
</div></fieldset>
';
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["indexes"])) {
	$a = $_GET["indexes"];
	$Nd = array("PRIMARY", "UNIQUE", "INDEX");
	$R = table_status($a, true);
	if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Nd[] = "FULLTEXT";
	if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Nd[] = "SPATIAL";
	$w = indexes($a);
	$pg = array();
	if ($x == "mongo") {
		$pg = $w["_id_"];
		unset($Nd[0]);
		unset($w["_id_"]);
	}
	$I = $_POST;
	if ($_POST && !$n && !$_POST["add"] && !$_POST["drop_col"]) {
		$c = array();
		foreach ($I["indexes"] as $v) {
			$B = $v["name"];
			if (in_array($v["type"], $Nd)) {
				$f = array();
				$ze = array();
				$cc = array();
				$N = array();
				ksort($v["columns"]);
				foreach ($v["columns"] as $y => $e) {
					if ($e != "") {
						$ye = $v["lengths"][$y];
						$bc = $v["descs"][$y];
						$N[] = idf_escape($e) . ($ye ? "(" . (+$ye) . ")" : "") . ($bc ? " DESC" : "");
						$f[] = $e;
						$ze[] = ($ye ? $ye : null);
						$cc[] = $bc;
					}
				}
				if ($f) {
					$Hc = $w[$B];
					if ($Hc) {
						ksort($Hc["columns"]);
						ksort($Hc["lengths"]);
						ksort($Hc["descs"]);
						if ($v["type"] == $Hc["type"] && array_values($Hc["columns"]) === $f && (!$Hc["lengths"] || array_values($Hc["lengths"]) === $ze) && array_values($Hc["descs"]) === $cc) {
							unset($w[$B]);
							continue;
						}
					}
					$c[] = array($v["type"], $B, $N);
				}
			}
		}
		foreach ($w
				 as $B => $Hc) $c[] = array($Hc["type"], $B, "DROP");
		if (!$c) redirect(ME . "table=" . urlencode($a));
		queries_redirect(ME . "table=" . urlencode($a), lang(180), alter_indexes($a, $c));
	}
	page_header(lang(132), $n, array("table" => $a), h($a));
	$p = array_keys(fields($a));
	if ($_POST["add"]) {
		foreach ($I["indexes"] as $y => $v) {
			if ($v["columns"][count($v["columns"])] != "") $I["indexes"][$y]["columns"][] = "";
		}
		$v = end($I["indexes"]);
		if ($v["type"] || array_filter($v["columns"], 'strlen')) $I["indexes"][] = array("columns" => array(1 => ""));
	}
	if (!$I) {
		foreach ($w
				 as $y => $v) {
			$w[$y]["name"] = $y;
			$w[$y]["columns"][] = "";
		}
		$w[] = array("columns" => array(1 => ""));
		$I["indexes"] = $w;
	}
	echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">', lang(181), '<th><input type="submit" class="wayoff">', lang(182), '<th id="label-name">', lang(183), '<th><noscript>', "<input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . lang(108) . "'>", '</noscript>
</thead>
';
	if ($pg) {
		echo "<tr><td>PRIMARY<td>";
		foreach ($pg["columns"] as $y => $e) {
			echo
			select_input(" disabled", $p, $e), "<label><input disabled type='checkbox'>" . lang(60) . "</label> ";
		}
		echo "<td><td>\n";
	}
	$ge = 1;
	foreach ($I["indexes"] as $v) {
		if (!$_POST["drop_col"] || $ge != key($_POST["drop_col"])) {
			echo "<tr><td>" . html_select("indexes[$ge][type]", array(-1 => "") + $Nd, $v["type"], ($ge == count($I["indexes"]) ? "indexesAddRow.call(this);" : 1), "label-type"), "<td>";
			ksort($v["columns"]);
			$s = 1;
			foreach ($v["columns"] as $y => $e) {
				echo "<span>" . select_input(" name='indexes[$ge][columns][$s]' title='" . lang(49) . "'", ($p ? array_combine($p, $p) : $p), $e, "partial(" . ($s == count($v["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($x == "sql" ? "" : $_GET["indexes"] . "_") . "')"), ($x == "sql" || $x == "mssql" ? "<input type='number' name='indexes[$ge][lengths][$s]' class='size' value='" . h($v["lengths"][$y]) . "' title='" . lang(106) . "'>" : ""), (support("descidx") ? checkbox("indexes[$ge][descs][$s]", 1, $v["descs"][$y], lang(60)) : ""), " </span>";
				$s++;
			}
			echo "<td><input name='indexes[$ge][name]' value='" . h($v["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n", "<td><input type='image' class='icon' name='drop_col[$ge]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.7.7") . "' alt='x' title='" . lang(111) . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
		}
		$ge++;
	}
	echo '</table>
</div>
<p>
<input type="submit" value="', lang(14), '">
<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["database"])) {
	$I = $_POST;
	if ($_POST && !$n && !isset($_POST["add_x"])) {
		$B = trim($I["name"]);
		if ($_POST["drop"]) {
			$_GET["db"] = "";
			queries_redirect(remove_from_uri("db|database"), lang(184), drop_databases(array(DB)));
		} elseif (DB !== $B) {
			if (DB != "") {
				$_GET["db"] = $B;
				queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($B), lang(185), rename_database($B, $I["collation"]));
			} else {
				$k = explode("\n", str_replace("\r", "", $B));
				$Oh = true;
				$se = "";
				foreach ($k
						 as $l) {
					if (count($k) == 1 || $l != "") {
						if (!create_database($l, $I["collation"])) $Oh = false;
						$se = $l;
					}
				}
				restart_session();
				set_session("dbs", null);
				queries_redirect(ME . "db=" . urlencode($se), lang(186), $Oh);
			}
		} else {
			if (!$I["collation"]) redirect(substr(ME, 0, -1));
			query_redirect("ALTER DATABASE " . idf_escape($B) . (preg_match('~^[a-z0-9_]+$~i', $I["collation"]) ? " COLLATE $I[collation]" : ""), substr(ME, 0, -1), lang(187));
		}
	}
	page_header(DB != "" ? lang(68) : lang(115), $n, array(), h(DB));
	$qb = collations();
	$B = DB;
	if ($_POST) $B = $I["name"]; elseif (DB != "") $I["collation"] = db_collation(DB, $qb);
    elseif ($x == "sql") {
		foreach (get_vals("SHOW GRANTS") as $pd) {
			if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $pd, $A) && $A[1]) {
				$B = stripcslashes(idf_unescape("`$A[2]`"));
				break;
			}
		}
	}
	echo '
<form action="" method="post">
<p>
', ($_POST["add_x"] || strpos($B, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($B) . '</textarea><br>' : '<input name="name" id="name" value="' . h($B) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($qb ? html_select("collation", array("" => "(" . lang(101) . ")") + $qb, $I["collation"]) . doc_link(array('sql' => "charset-charsets.html", 'mariadb' => "supported-character-sets-and-collations/", 'mssql' => "ms187963.aspx",)) : ""), script("focus(qs('#name'));"), '<input type="submit" value="', lang(14), '">
';
	if (DB != "") echo "<input type='submit' name='drop' value='" . lang(127) . "'>" . confirm(lang(175, DB)) . "\n"; elseif (!$_POST["add_x"] && $_GET["db"] == "") echo "<input type='image' class='icon' name='add' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.7.7") . "' alt='+' title='" . lang(108) . "'>\n";
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["scheme"])) {
	$I = $_POST;
	if ($_POST && !$n) {
		$_ = preg_replace('~ns=[^&]*&~', '', ME) . "ns=";
		if ($_POST["drop"]) query_redirect("DROP SCHEMA " . idf_escape($_GET["ns"]), $_, lang(188)); else {
			$B = trim($I["name"]);
			$_ .= urlencode($B);
			if ($_GET["ns"] == "") query_redirect("CREATE SCHEMA " . idf_escape($B), $_, lang(189)); elseif ($_GET["ns"] != $B) query_redirect("ALTER SCHEMA " . idf_escape($_GET["ns"]) . " RENAME TO " . idf_escape($B), $_, lang(190));
			else
				redirect($_);
		}
	}
	page_header($_GET["ns"] != "" ? lang(69) : lang(70), $n);
	if (!$I) $I["name"] = $_GET["ns"];
	echo '
<form action="" method="post">
<p><input name="name" id="name" value="', h($I["name"]), '" autocapitalize="off">
', script("focus(qs('#name'));"), '<input type="submit" value="', lang(14), '">
';
	if ($_GET["ns"] != "") echo "<input type='submit' name='drop' value='" . lang(127) . "'>" . confirm(lang(175, $_GET["ns"])) . "\n";
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["call"])) {
	$da = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
	page_header(lang(191) . ": " . h($da), $n);
	$Zg = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
	$Ld = array();
	$Of = array();
	foreach ($Zg["fields"] as $s => $o) {
		if (substr($o["inout"], -3) == "OUT") $Of[$s] = "@" . idf_escape($o["field"]) . " AS " . idf_escape($o["field"]);
		if (!$o["inout"] || substr($o["inout"], 0, 2) == "IN") $Ld[] = $s;
	}
	if (!$n && $_POST) {
		$bb = array();
		foreach ($Zg["fields"] as $y => $o) {
			if (in_array($y, $Ld)) {
				$X = process_input($o);
				if ($X === false) $X = "''";
				if (isset($Of[$y])) $h->query("SET @" . idf_escape($o["field"]) . " = $X");
			}
			$bb[] = (isset($Of[$y]) ? "@" . idf_escape($o["field"]) : $X);
		}
		$F = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($da) . "(" . implode(", ", $bb) . ")";
		$Ih = microtime(true);
		$G = $h->multi_query($F);
		$_a = $h->affected_rows;
		echo $b->selectQuery($F, $Ih, !$G);
		if (!$G) echo "<p class='error'>" . error() . "\n"; else {
			$i = connect();
			if (is_object($i)) $i->select_db(DB);
			do {
				$G = $h->store_result();
				if (is_object($G)) select($G, $i); else
					echo "<p class='message'>" . lang(192, $_a) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
			} while ($h->next_result());
			if ($Of) select($h->query("SELECT " . implode(", ", $Of)));
		}
	}
	echo '
<form action="" method="post">
';
	if ($Ld) {
		echo "<table cellspacing='0' class='layout'>\n";
		foreach ($Ld
				 as $y) {
			$o = $Zg["fields"][$y];
			$B = $o["field"];
			echo "<tr><th>" . $b->fieldName($o);
			$Y = $_POST["fields"][$B];
			if ($Y != "") {
				if ($o["type"] == "enum") $Y = +$Y;
				if ($o["type"] == "set") $Y = array_sum($Y);
			}
			input($o, $Y, (string)$_POST["function"][$B]);
			echo "\n";
		}
		echo "</table>\n";
	}
	echo '<p>
<input type="submit" value="', lang(191), '">
<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["foreign"])) {
	$a = $_GET["foreign"];
	$B = $_GET["name"];
	$I = $_POST;
	if ($_POST && !$n && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
		$Qe = ($_POST["drop"] ? lang(193) : ($B != "" ? lang(194) : lang(195)));
		$Be = ME . "table=" . urlencode($a);
		if (!$_POST["drop"]) {
			$I["source"] = array_filter($I["source"], 'strlen');
			ksort($I["source"]);
			$ci = array();
			foreach ($I["source"] as $y => $X) $ci[$y] = $I["target"][$y];
			$I["target"] = $ci;
		}
		if ($x == "sqlite") queries_redirect($Be, $Qe, recreate_table($a, $a, array(), array(), array(" $B" => ($_POST["drop"] ? "" : " " . format_foreign_key($I))))); else {
			$c = "ALTER TABLE " . table($a);
			$jc = "\nDROP " . ($x == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($B);
			if ($_POST["drop"]) query_redirect($c . $jc, $Be, $Qe); else {
				query_redirect($c . ($B != "" ? "$jc," : "") . "\nADD" . format_foreign_key($I), $Be, $Qe);
				$n = lang(196) . "<br>$n";
			}
		}
	}
	page_header(lang(197), $n, array("table" => $a), h($a));
	if ($_POST) {
		ksort($I["source"]);
		if ($_POST["add"]) $I["source"][] = ""; elseif ($_POST["change"] || $_POST["change-js"]) $I["target"] = array();
	} elseif ($B != "") {
		$id = foreign_keys($a);
		$I = $id[$B];
		$I["source"][] = "";
	} else {
		$I["table"] = $a;
		$I["source"] = array("");
	}
	echo '
<form action="" method="post">
';
	$Ah = array_keys(fields($a));
	if ($I["db"] != "") $h->select_db($I["db"]);
	if ($I["ns"] != "") set_schema($I["ns"]);
	$Ig = array_keys(array_filter(table_status('', true), 'fk_support'));
	$ci = ($a === $I["table"] ? $Ah : array_keys(fields(in_array($I["table"], $Ig) ? $I["table"] : reset($Ig))));
	$wf = "this.form['change-js'].value = '1'; this.form.submit();";
	echo "<p>" . lang(198) . ": " . html_select("table", $Ig, $I["table"], $wf) . "\n";
	if ($x == "pgsql") echo
		lang(78) . ": " . html_select("ns", $b->schemas(), $I["ns"] != "" ? $I["ns"] : $_GET["ns"], $wf); elseif ($x != "sqlite") {
		$Ub = array();
		foreach ($b->databases() as $l) {
			if (!information_schema($l)) $Ub[] = $l;
		}
		echo
			lang(77) . ": " . html_select("db", $Ub, $I["db"] != "" ? $I["db"] : $_GET["db"], $wf);
	}
	echo '<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="', lang(199), '"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">', lang(134), '<th id="label-target">', lang(135), '</thead>
';
	$ge = 0;
	foreach ($I["source"] as $y => $X) {
		echo "<tr>", "<td>" . html_select("source[" . (+$y) . "]", array(-1 => "") + $Ah, $X, ($ge == count($I["source"]) - 1 ? "foreignAddRow.call(this);" : 1), "label-source"), "<td>" . html_select("target[" . (+$y) . "]", $ci, $I["target"][$y], 1, "label-target");
		$ge++;
	}
	echo '</table>
<p>
', lang(103), ': ', html_select("on_delete", array(-1 => "") + explode("|", $vf), $I["on_delete"]), ' ', lang(102), ': ', html_select("on_update", array(-1 => "") + explode("|", $vf), $I["on_update"]), doc_link(array('sql' => "innodb-foreign-key-constraints.html", 'mariadb' => "foreign-keys/", 'pgsql' => "sql-createtable.html#SQL-CREATETABLE-REFERENCES", 'mssql' => "ms174979.aspx", 'oracle' => "https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)), '<p>
<input type="submit" value="', lang(14), '">
<noscript><p><input type="submit" name="add" value="', lang(200), '"></noscript>
';
	if ($B != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $B));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["view"])) {
	$a = $_GET["view"];
	$I = $_POST;
	$Lf = "VIEW";
	if ($x == "pgsql" && $a != "") {
		$O = table_status($a);
		$Lf = strtoupper($O["Engine"]);
	}
	if ($_POST && !$n) {
		$B = trim($I["name"]);
		$Ha = " AS\n$I[select]";
		$Be = ME . "table=" . urlencode($B);
		$Qe = lang(201);
		$T = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
		if (!$_POST["drop"] && $a == $B && $x != "sqlite" && $T == "VIEW" && $Lf == "VIEW") query_redirect(($x == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($B) . $Ha, $Be, $Qe); else {
			$ei = $B . "_adminer_" . uniqid();
			drop_create("DROP $Lf " . table($a), "CREATE $T " . table($B) . $Ha, "DROP $T " . table($B), "CREATE $T " . table($ei) . $Ha, "DROP $T " . table($ei), ($_POST["drop"] ? substr(ME, 0, -1) : $Be), lang(202), $Qe, lang(203), $a, $B);
		}
	}
	if (!$_POST && $a != "") {
		$I = view($a);
		$I["name"] = $a;
		$I["materialized"] = ($Lf != "VIEW");
		if (!$n) $n = error();
	}
	page_header(($a != "" ? lang(44) : lang(204)), $n, array("table" => $a), h($a));
	echo '
<form action="" method="post">
<p>', lang(183), ': <input name="name" value="', h($I["name"]), '" data-maxlength="64" autocapitalize="off">
', (support("materializedview") ? " " . checkbox("materialized", 1, $I["materialized"], lang(129)) : ""), '<p>';
	textarea("select", $I["select"]);
	echo '<p>
<input type="submit" value="', lang(14), '">
';
	if ($a != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $a));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["event"])) {
	$aa = $_GET["event"];
	$Yd = array("YEAR", "QUARTER", "MONTH", "DAY", "HOUR", "MINUTE", "WEEK", "SECOND", "YEAR_MONTH", "DAY_HOUR", "DAY_MINUTE", "DAY_SECOND", "HOUR_MINUTE", "HOUR_SECOND", "MINUTE_SECOND");
	$Kh = array("ENABLED" => "ENABLE", "DISABLED" => "DISABLE", "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE");
	$I = $_POST;
	if ($_POST && !$n) {
		if ($_POST["drop"]) query_redirect("DROP EVENT " . idf_escape($aa), substr(ME, 0, -1), lang(205)); elseif (in_array($I["INTERVAL_FIELD"], $Yd) && isset($Kh[$I["STATUS"]])) {
			$eh = "\nON SCHEDULE " . ($I["INTERVAL_VALUE"] ? "EVERY " . q($I["INTERVAL_VALUE"]) . " $I[INTERVAL_FIELD]" . ($I["STARTS"] ? " STARTS " . q($I["STARTS"]) : "") . ($I["ENDS"] ? " ENDS " . q($I["ENDS"]) : "") : "AT " . q($I["STARTS"])) . " ON COMPLETION" . ($I["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
			queries_redirect(substr(ME, 0, -1), ($aa != "" ? lang(206) : lang(207)), queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $eh . ($aa != $I["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($I["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($I["EVENT_NAME"]) . $eh) . "\n" . $Kh[$I["STATUS"]] . " COMMENT " . q($I["EVENT_COMMENT"]) . rtrim(" DO\n$I[EVENT_DEFINITION]", ";") . ";"));
		}
	}
	page_header(($aa != "" ? lang(208) . ": " . h($aa) : lang(209)), $n);
	if (!$I && $aa != "") {
		$J = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
		$I = reset($J);
	}
	echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>', lang(183), '<td><input name="EVENT_NAME" value="', h($I["EVENT_NAME"]), '" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">', lang(210), '<td><input name="STARTS" value="', h("$I[EXECUTE_AT]$I[STARTS]"), '">
<tr><th title="datetime">', lang(211), '<td><input name="ENDS" value="', h($I["ENDS"]), '">
<tr><th>', lang(212), '<td><input type="number" name="INTERVAL_VALUE" value="', h($I["INTERVAL_VALUE"]), '" class="size"> ', html_select("INTERVAL_FIELD", $Yd, $I["INTERVAL_FIELD"]), '<tr><th>', lang(118), '<td>', html_select("STATUS", $Kh, $I["STATUS"]), '<tr><th>', lang(51), '<td><input name="EVENT_COMMENT" value="', h($I["EVENT_COMMENT"]), '" data-maxlength="64">
<tr><th><td>', checkbox("ON_COMPLETION", "PRESERVE", $I["ON_COMPLETION"] == "PRESERVE", lang(213)), '</table>
<p>';
	textarea("EVENT_DEFINITION", $I["EVENT_DEFINITION"]);
	echo '<p>
<input type="submit" value="', lang(14), '">
';
	if ($aa != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $aa));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["procedure"])) {
	$da = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
	$Zg = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
	$I = $_POST;
	$I["fields"] = (array)$I["fields"];
	if ($_POST && !process_fields($I["fields"]) && !$n) {
		$If = routine($_GET["procedure"], $Zg);
		$ei = "$I[name]_adminer_" . uniqid();
		drop_create("DROP $Zg " . routine_id($da, $If), create_routine($Zg, $I), "DROP $Zg " . routine_id($I["name"], $I), create_routine($Zg, array("name" => $ei) + $I), "DROP $Zg " . routine_id($ei, $I), substr(ME, 0, -1), lang(214), lang(215), lang(216), $da, $I["name"]);
	}
	page_header(($da != "" ? (isset($_GET["function"]) ? lang(217) : lang(218)) . ": " . h($da) : (isset($_GET["function"]) ? lang(219) : lang(220))), $n);
	if (!$_POST && $da != "") {
		$I = routine($_GET["procedure"], $Zg);
		$I["name"] = $da;
	}
	$qb = get_vals("SHOW CHARACTER SET");
	sort($qb);
	$ah = routine_languages();
	echo '
<form action="" method="post" id="form">
<p>', lang(183), ': <input name="name" value="', h($I["name"]), '" data-maxlength="64" autocapitalize="off">
', ($ah ? lang(19) . ": " . html_select("language", $ah, $I["language"]) . "\n" : ""), '<input type="submit" value="', lang(14), '">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
	edit_fields($I["fields"], $qb, $Zg);
	if (isset($_GET["function"])) {
		echo "<tr><td>" . lang(221);
		edit_type("returns", $I["returns"], $qb, array(), ($x == "pgsql" ? array("void", "trigger") : array()));
	}
	echo '</table>
', script("editFields();"), '</div>
<p>';
	textarea("definition", $I["definition"]);
	echo '<p>
<input type="submit" value="', lang(14), '">
';
	if ($da != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $da));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["sequence"])) {
	$fa = $_GET["sequence"];
	$I = $_POST;
	if ($_POST && !$n) {
		$_ = substr(ME, 0, -1);
		$B = trim($I["name"]);
		if ($_POST["drop"]) query_redirect("DROP SEQUENCE " . idf_escape($fa), $_, lang(222)); elseif ($fa == "") query_redirect("CREATE SEQUENCE " . idf_escape($B), $_, lang(223));
        elseif ($fa != $B) query_redirect("ALTER SEQUENCE " . idf_escape($fa) . " RENAME TO " . idf_escape($B), $_, lang(224));
		else
			redirect($_);
	}
	page_header($fa != "" ? lang(225) . ": " . h($fa) : lang(226), $n);
	if (!$I) $I["name"] = $fa;
	echo '
<form action="" method="post">
<p><input name="name" value="', h($I["name"]), '" autocapitalize="off">
<input type="submit" value="', lang(14), '">
';
	if ($fa != "") echo "<input type='submit' name='drop' value='" . lang(127) . "'>" . confirm(lang(175, $fa)) . "\n";
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["type"])) {
	$ga = $_GET["type"];
	$I = $_POST;
	if ($_POST && !$n) {
		$_ = substr(ME, 0, -1);
		if ($_POST["drop"]) query_redirect("DROP TYPE " . idf_escape($ga), $_, lang(227)); else
			query_redirect("CREATE TYPE " . idf_escape(trim($I["name"])) . " $I[as]", $_, lang(228));
	}
	page_header($ga != "" ? lang(229) . ": " . h($ga) : lang(230), $n);
	if (!$I) $I["as"] = "AS ";
	echo '
<form action="" method="post">
<p>
';
	if ($ga != "") echo "<input type='submit' name='drop' value='" . lang(127) . "'>" . confirm(lang(175, $ga)) . "\n"; else {
		echo "<input name='name' value='" . h($I['name']) . "' autocapitalize='off'>\n";
		textarea("as", $I["as"]);
		echo "<p><input type='submit' value='" . lang(14) . "'>\n";
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["trigger"])) {
	$a = $_GET["trigger"];
	$B = $_GET["name"];
	$Di = trigger_options();
	$I = (array)trigger($B) + array("Trigger" => $a . "_bi");
	if ($_POST) {
		if (!$n && in_array($_POST["Timing"], $Di["Timing"]) && in_array($_POST["Event"], $Di["Event"]) && in_array($_POST["Type"], $Di["Type"])) {
			$uf = " ON " . table($a);
			$jc = "DROP TRIGGER " . idf_escape($B) . ($x == "pgsql" ? $uf : "");
			$Be = ME . "table=" . urlencode($a);
			if ($_POST["drop"]) query_redirect($jc, $Be, lang(231)); else {
				if ($B != "") queries($jc);
				queries_redirect($Be, ($B != "" ? lang(232) : lang(233)), queries(create_trigger($uf, $_POST)));
				if ($B != "") queries(create_trigger($uf, $I + array("Type" => reset($Di["Type"]))));
			}
		}
		$I = $_POST;
	}
	page_header(($B != "" ? lang(234) . ": " . h($B) : lang(235)), $n, array("table" => $a));
	echo '
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>', lang(236), '<td>', html_select("Timing", $Di["Timing"], $I["Timing"], "triggerChange(/^" . preg_quote($a, "/") . "_[ba][iud]$/, '" . js_escape($a) . "', this.form);"), '<tr><th>', lang(237), '<td>', html_select("Event", $Di["Event"], $I["Event"], "this.form['Timing'].onchange();"), (in_array("UPDATE OF", $Di["Event"]) ? " <input name='Of' value='" . h($I["Of"]) . "' class='hidden'>" : ""), '<tr><th>', lang(50), '<td>', html_select("Type", $Di["Type"], $I["Type"]), '</table>
<p>', lang(183), ': <input name="Trigger" value="', h($I["Trigger"]), '" data-maxlength="64" autocapitalize="off">
', script("qs('#form')['Timing'].onchange();"), '<p>';
	textarea("Statement", $I["Statement"]);
	echo '<p>
<input type="submit" value="', lang(14), '">
';
	if ($B != "") {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, $B));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["user"])) {
	$ha = $_GET["user"];
	$ug = array("" => array("All privileges" => ""));
	foreach (get_rows("SHOW PRIVILEGES") as $I) {
		foreach (explode(",", ($I["Privilege"] == "Grant option" ? "" : $I["Context"])) as $Db) $ug[$Db][$I["Privilege"]] = $I["Comment"];
	}
	$ug["Server Admin"] += $ug["File access on server"];
	$ug["Databases"]["Create routine"] = $ug["Procedures"]["Create routine"];
	unset($ug["Procedures"]["Create routine"]);
	$ug["Columns"] = array();
	foreach (array("Select", "Insert", "Update", "References") as $X) $ug["Columns"][$X] = $ug["Tables"][$X];
	unset($ug["Server Admin"]["Usage"]);
	foreach ($ug["Tables"] as $y => $X) unset($ug["Databases"][$y]);
	$df = array();
	if ($_POST) {
		foreach ($_POST["objects"] as $y => $X) $df[$X] = (array)$df[$X] + (array)$_POST["grants"][$y];
	}
	$qd = array();
	$sf = "";
	if (isset($_GET["host"]) && ($G = $h->query("SHOW GRANTS FOR " . q($ha) . "@" . q($_GET["host"])))) {
		while ($I = $G->fetch_row()) {
			if (preg_match('~GRANT (.*) ON (.*) TO ~', $I[0], $A) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $A[1], $Ie, PREG_SET_ORDER)) {
				foreach ($Ie
						 as $X) {
					if ($X[1] != "USAGE") $qd["$A[2]$X[2]"][$X[1]] = true;
					if (preg_match('~ WITH GRANT OPTION~', $I[0])) $qd["$A[2]$X[2]"]["GRANT OPTION"] = true;
				}
			}
			if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $I[0], $A)) $sf = $A[1];
		}
	}
	if ($_POST && !$n) {
		$tf = (isset($_GET["host"]) ? q($ha) . "@" . q($_GET["host"]) : "''");
		if ($_POST["drop"]) query_redirect("DROP USER $tf", ME . "privileges=", lang(238)); else {
			$ff = q($_POST["user"]) . "@" . q($_POST["host"]);
			$cg = $_POST["pass"];
			if ($cg != '' && !$_POST["hashed"] && !min_version(8)) {
				$cg = $h->result("SELECT PASSWORD(" . q($cg) . ")");
				$n = !$cg;
			}
			$Jb = false;
			if (!$n) {
				if ($tf != $ff) {
					$Jb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $ff IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($cg));
					$n = !$Jb;
				} elseif ($cg != $sf) queries("SET PASSWORD FOR $ff = " . q($cg));
			}
			if (!$n) {
				$Wg = array();
				foreach ($df
						 as $nf => $pd) {
					if (isset($_GET["grant"])) $pd = array_filter($pd);
					$pd = array_keys($pd);
					if (isset($_GET["grant"])) $Wg = array_diff(array_keys(array_filter($df[$nf], 'strlen')), $pd); elseif ($tf == $ff) {
						$qf = array_keys((array)$qd[$nf]);
						$Wg = array_diff($qf, $pd);
						$pd = array_diff($pd, $qf);
						unset($qd[$nf]);
					}
					if (preg_match('~^(.+)\s*(\(.*\))?$~U', $nf, $A) && (!grant("REVOKE", $Wg, $A[2], " ON $A[1] FROM $ff") || !grant("GRANT", $pd, $A[2], " ON $A[1] TO $ff"))) {
						$n = true;
						break;
					}
				}
			}
			if (!$n && isset($_GET["host"])) {
				if ($tf != $ff) queries("DROP USER $tf"); elseif (!isset($_GET["grant"])) {
					foreach ($qd
							 as $nf => $Wg) {
						if (preg_match('~^(.+)(\(.*\))?$~U', $nf, $A)) grant("REVOKE", array_keys($Wg), $A[2], " ON $A[1] FROM $ff");
					}
				}
			}
			queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? lang(239) : lang(240)), !$n);
			if ($Jb) $h->query("DROP USER $ff");
		}
	}
	page_header((isset($_GET["host"]) ? lang(36) . ": " . h("$ha@$_GET[host]") : lang(146)), $n, array("privileges" => array('', lang(72))));
	if ($_POST) {
		$I = $_POST;
		$qd = $df;
	} else {
		$I = $_GET + array("host" => $h->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));
		$I["pass"] = $sf;
		if ($sf != "") $I["hashed"] = true;
		$qd[(DB == "" || $qd ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
	}
	echo '<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>', lang(35), '<td><input name="host" data-maxlength="60" value="', h($I["host"]), '" autocapitalize="off">
<tr><th>', lang(36), '<td><input name="user" data-maxlength="80" value="', h($I["user"]), '" autocapitalize="off">
<tr><th>', lang(37), '<td><input name="pass" id="pass" value="', h($I["pass"]), '" autocomplete="new-password">
';
	if (!$I["hashed"]) echo
	script("typePassword(qs('#pass'));");
	echo(min_version(8) ? "" : checkbox("hashed", 1, $I["hashed"], lang(241), "typePassword(this.form['pass'], this.checked);")), '</table>

';
	echo "<table cellspacing='0'>\n", "<thead><tr><th colspan='2'>" . lang(72) . doc_link(array('sql' => "grant.html#priv_level"));
	$s = 0;
	foreach ($qd
			 as $nf => $pd) {
		echo '<th>' . ($nf != "*.*" ? "<input name='objects[$s]' value='" . h($nf) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$s]' value='*.*' size='10'>*.*");
		$s++;
	}
	echo "</thead>\n";
	foreach (array("" => "", "Server Admin" => lang(35), "Databases" => lang(38), "Tables" => lang(131), "Columns" => lang(49), "Procedures" => lang(242),) as $Db => $bc) {
		foreach ((array)$ug[$Db] as $tg => $vb) {
			echo "<tr" . odd() . "><td" . ($bc ? ">$bc<td" : " colspan='2'") . ' lang="en" title="' . h($vb) . '">' . h($tg);
			$s = 0;
			foreach ($qd
					 as $nf => $pd) {
				$B = "'grants[$s][" . h(strtoupper($tg)) . "]'";
				$Y = $pd[strtoupper($tg)];
				if ($Db == "Server Admin" && $nf != (isset($qd["*.*"]) ? "*.*" : ".*")) echo "<td>"; elseif (isset($_GET["grant"])) echo "<td><select name=$B><option><option value='1'" . ($Y ? " selected" : "") . ">" . lang(243) . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . lang(244) . "</select>";
				else {
					echo "<td align='center'><label class='block'>", "<input type='checkbox' name=$B value='1'" . ($Y ? " checked" : "") . ($tg == "All privileges" ? " id='grants-$s-all'>" : ">" . ($tg == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$s-all'); };"))), "</label>";
				}
				$s++;
			}
		}
	}
	echo "</table>\n", '<p>
<input type="submit" value="', lang(14), '">
';
	if (isset($_GET["host"])) {
		echo '<input type="submit" name="drop" value="', lang(127), '">', confirm(lang(175, "$ha@$_GET[host]"));
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
';
} elseif (isset($_GET["processlist"])) {
	if (support("kill") && $_POST && !$n) {
		$ne = 0;
		foreach ((array)$_POST["kill"] as $X) {
			if (kill_process($X)) $ne++;
		}
		queries_redirect(ME . "processlist=", lang(245, $ne), $ne || !$_POST["kill"]);
	}
	page_header(lang(116), $n);
	echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
', script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
	$s = -1;
	foreach (process_list() as $s => $I) {
		if (!$s) {
			echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
			foreach ($I
					 as $y => $X) echo "<th>$y" . doc_link(array('sql' => "show-processlist.html#processlist_" . strtolower($y), 'pgsql' => "monitoring-stats.html#PG-STAT-ACTIVITY-VIEW", 'oracle' => "REFRN30223",));
			echo "</thead>\n";
		}
		echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $I[$x == "sql" ? "Id" : "pid"], 0) : "");
		foreach ($I
				 as $y => $X) echo "<td>" . (($x == "sql" && $y == "Info" && preg_match("~Query|Killed~", $I["Command"]) && $X != "") || ($x == "pgsql" && $y == "current_query" && $X != "<IDLE>") || ($x == "oracle" && $y == "sql_text" && $X != "") ? "<code class='jush-$x'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($I["db"] != "" ? "db=" . urlencode($I["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">' . lang(246) . '</a>' : h($X));
		echo "\n";
	}
	echo '</table>
</div>
<p>
';
	if (support("kill")) {
		echo ($s + 1) . "/" . lang(247, max_connections()), "<p><input type='submit' value='" . lang(248) . "'>\n";
	}
	echo '<input type="hidden" name="token" value="', $ti, '">
</form>
', script("tableCheck();");
} elseif (isset($_GET["select"])) {
	$a = $_GET["select"];
	$R = table_status1($a);
	$w = indexes($a);
	$p = fields($a);
	$id = column_foreign_keys($a);
	$pf = $R["Oid"];
	parse_str($_COOKIE["adminer_import"], $za);
	$Xg = array();
	$f = array();
	$ii = null;
	foreach ($p
			 as $y => $o) {
		$B = $b->fieldName($o);
		if (isset($o["privileges"]["select"]) && $B != "") {
			$f[$y] = html_entity_decode(strip_tags($B), ENT_QUOTES);
			if (is_shortable($o)) $ii = $b->selectLengthProcess();
		}
		$Xg += $o["privileges"];
	}
	list($K, $rd) = $b->selectColumnsProcess($f, $w);
	$ce = count($rd) < count($K);
	$Z = $b->selectSearchProcess($p, $w);
	$Ef = $b->selectOrderProcess($p, $w);
	$z = $b->selectLimitProcess();
	if ($_GET["val"] && is_ajax()) {
		header("Content-Type: text/plain; charset=utf-8");
		foreach ($_GET["val"] as $Ki => $I) {
			$Ha = convert_field($p[key($I)]);
			$K = array($Ha ? $Ha : idf_escape(key($I)));
			$Z[] = where_check($Ki, $p);
			$H = $m->select($a, $K, $Z, $K);
			if ($H) echo
			reset($H->fetch_row());
		}
		exit;
	}
	$pg = $Mi = null;
	foreach ($w
			 as $v) {
		if ($v["type"] == "PRIMARY") {
			$pg = array_flip($v["columns"]);
			$Mi = ($K ? $pg : array());
			foreach ($Mi
					 as $y => $X) {
				if (in_array(idf_escape($y), $K)) unset($Mi[$y]);
			}
			break;
		}
	}
	if ($pf && !$pg) {
		$pg = $Mi = array($pf => 0);
		$w[] = array("type" => "PRIMARY", "columns" => array($pf));
	}
	if ($_POST && !$n) {
		$oj = $Z;
		if (!$_POST["all"] && is_array($_POST["check"])) {
			$hb = array();
			foreach ($_POST["check"] as $eb) $hb[] = where_check($eb, $p);
			$oj[] = "((" . implode(") OR (", $hb) . "))";
		}
		$oj = ($oj ? "\nWHERE " . implode(" AND ", $oj) : "");
		if ($_POST["export"]) {
			cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
			dump_headers($a);
			$b->dumpTable($a, "");
			$nd = ($K ? implode(", ", $K) : "*") . convert_fields($f, $p, $K) . "\nFROM " . table($a);
			$td = ($rd && $ce ? "\nGROUP BY " . implode(", ", $rd) : "") . ($Ef ? "\nORDER BY " . implode(", ", $Ef) : "");
			if (!is_array($_POST["check"]) || $pg) $F = "SELECT $nd$oj$td"; else {
				$Ii = array();
				foreach ($_POST["check"] as $X) $Ii[] = "(SELECT" . limit($nd, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $p) . $td, 1) . ")";
				$F = implode(" UNION ALL ", $Ii);
			}
			$b->dumpData($a, "table", $F);
			exit;
		}
		if (!$b->selectEmailProcess($Z, $id)) {
			if ($_POST["save"] || $_POST["delete"]) {
				$G = true;
				$_a = 0;
				$N = array();
				if (!$_POST["delete"]) {
					foreach ($f
							 as $B => $X) {
						$X = process_input($p[$B]);
						if ($X !== null && ($_POST["clone"] || $X !== false)) $N[idf_escape($B)] = ($X !== false ? $X : idf_escape($B));
					}
				}
				if ($_POST["delete"] || $N) {
					if ($_POST["clone"]) $F = "INTO " . table($a) . " (" . implode(", ", array_keys($N)) . ")\nSELECT " . implode(", ", $N) . "\nFROM " . table($a);
					if ($_POST["all"] || ($pg && is_array($_POST["check"])) || $ce) {
						$G = ($_POST["delete"] ? $m->delete($a, $oj) : ($_POST["clone"] ? queries("INSERT $F$oj") : $m->update($a, $N, $oj)));
						$_a = $h->affected_rows;
					} else {
						foreach ((array)$_POST["check"] as $X) {
							$kj = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $p);
							$G = ($_POST["delete"] ? $m->delete($a, $kj, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($a, $F, $kj)) : $m->update($a, $N, $kj, 1)));
							if (!$G) break;
							$_a += $h->affected_rows;
						}
					}
				}
				$Qe = lang(249, $_a);
				if ($_POST["clone"] && $G && $_a == 1) {
					$te = last_id();
					if ($te) $Qe = lang(168, " $te");
				}
				queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $Qe, $G);
				if (!$_POST["delete"]) {
					edit_form($a, $p, (array)$_POST["fields"], !$_POST["clone"]);
					page_footer();
					exit;
				}
			} elseif (!$_POST["import"]) {
				if (!$_POST["val"]) $n = lang(250); else {
					$G = true;
					$_a = 0;
					foreach ($_POST["val"] as $Ki => $I) {
						$N = array();
						foreach ($I
								 as $y => $X) {
							$y = bracket_escape($y, 1);
							$N[idf_escape($y)] = (preg_match('~char|text~', $p[$y]["type"]) || $X != "" ? $b->processInput($p[$y], $X) : "NULL");
						}
						$G = $m->update($a, $N, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($Ki, $p), !$ce && !$pg, " ");
						if (!$G) break;
						$_a += $h->affected_rows;
					}
					queries_redirect(remove_from_uri(), lang(249, $_a), $G);
				}
			} elseif (!is_string($Xc = get_file("csv_file", true))) $n = upload_error($Xc);
            elseif (!preg_match('~~u', $Xc)) $n = lang(251);
			else {
				cookie("adminer_import", "output=" . urlencode($za["output"]) . "&format=" . urlencode($_POST["separator"]));
				$G = true;
				$sb = array_keys($p);
				preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $Xc, $Ie);
				$_a = count($Ie[0]);
				$m->begin();
				$L = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
				$J = array();
				foreach ($Ie[0] as $y => $X) {
					preg_match_all("~((?>\"[^\"]*\")+|[^$L]*)$L~", $X . $L, $Je);
					if (!$y && !array_diff($Je[1], $sb)) {
						$sb = $Je[1];
						$_a--;
					} else {
						$N = array();
						foreach ($Je[1] as $s => $ob) $N[idf_escape($sb[$s])] = ($ob == "" && $p[$sb[$s]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $ob))));
						$J[] = $N;
					}
				}
				$G = (!$J || $m->insertUpdate($a, $J, $pg));
				if ($G) $G = $m->commit();
				queries_redirect(remove_from_uri("page"), lang(252, $_a), $G);
				$m->rollback();
			}
		}
	}
	$Uh = $b->tableName($R);
	if (is_ajax()) {
		page_headers();
		ob_start();
	} else
		page_header(lang(54) . ": $Uh", $n);
	$N = null;
	if (isset($Xg["insert"]) || !support("table")) {
		$N = "";
		foreach ((array)$_GET["where"] as $X) {
			if ($id[$X["col"]] && count($id[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"])))) $N .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
		}
	}
	$b->selectLinks($R, $N);
	if (!$f && support("table")) echo "<p class='error'>" . lang(253) . ($p ? "." : ": " . error()) . "\n"; else {
		echo "<form action='' id='form'>\n", "<div style='display: none;'>";
		hidden_fields_get();
		echo(DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
		echo '<input type="hidden" name="select" value="' . h($a) . '">', "</div>\n";
		$b->selectColumnsPrint($K, $f);
		$b->selectSearchPrint($Z, $f, $w);
		$b->selectOrderPrint($Ef, $f, $w);
		$b->selectLimitPrint($z);
		$b->selectLengthPrint($ii);
		$b->selectActionPrint($w);
		echo "</form>\n";
		$D = $_GET["page"];
		if ($D == "last") {
			$ld = $h->result(count_rows($a, $Z, $ce, $rd));
			$D = floor(max(0, $ld - 1) / $z);
		}
		$jh = $K;
		$sd = $rd;
		if (!$jh) {
			$jh[] = "*";
			$Eb = convert_fields($f, $p, $K);
			if ($Eb) $jh[] = substr($Eb, 2);
		}
		foreach ($K
				 as $y => $X) {
			$o = $p[idf_unescape($X)];
			if ($o && ($Ha = convert_field($o))) $jh[$y] = "$Ha AS $X";
		}
		if (!$ce && $Mi) {
			foreach ($Mi
					 as $y => $X) {
				$jh[] = idf_escape($y);
				if ($sd) $sd[] = idf_escape($y);
			}
		}
		$G = $m->select($a, $jh, $Z, $sd, $Ef, $z, $D, true);
		if (!$G) echo "<p class='error'>" . error() . "\n"; else {
			if ($x == "mssql" && $D) $G->seek($z * $D);
			$wc = array();
			echo "<form action='' method='post' enctype='multipart/form-data'>\n";
			$J = array();
			while ($I = $G->fetch_assoc()) {
				if ($D && $x == "oracle") unset($I["RNUM"]);
				$J[] = $I;
			}
			if ($_GET["page"] != "last" && $z != "" && $rd && $ce && $x == "sql") $ld = $h->result(" SELECT FOUND_ROWS()");
			if (!$J) echo "<p class='message'>" . lang(12) . "\n"; else {
				$Ra = $b->backwardKeys($a, $Uh);
				echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"), "<thead><tr>" . (!$rd && $K ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . lang(254) . "</a>");
				$cf = array();
				$od = array();
				reset($K);
				$Dg = 1;
				foreach ($J[0] as $y => $X) {
					if (!isset($Mi[$y])) {
						$X = $_GET["columns"][key($K)];
						$o = $p[$K ? ($X ? $X["col"] : current($K)) : $y];
						$B = ($o ? $b->fieldName($o, $Dg) : ($X["fun"] ? "*" : $y));
						if ($B != "") {
							$Dg++;
							$cf[$y] = $B;
							$e = idf_escape($y);
							$Fd = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($y);
							$bc = "&desc%5B0%5D=1";
							echo "<th>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""), '<a href="' . h($Fd . ($Ef[0] == $e || $Ef[0] == $y || (!$Ef && $ce && $rd[0] == $e) ? $bc : '')) . '">';
							echo
								apply_sql_function($X["fun"], $B) . "</a>";
							echo "<span class='column hidden'>", "<a href='" . h($Fd . $bc) . "' title='" . lang(60) . "' class='text'> ↓</a>";
							if (!$X["fun"]) {
								echo '<a href="#fieldset-search" title="' . lang(57) . '" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($y) . "');");
							}
							echo "</span>";
						}
						$od[$y] = $X["fun"];
						next($K);
					}
				}
				$ze = array();
				if ($_GET["modify"]) {
					foreach ($J
							 as $I) {
						foreach ($I
								 as $y => $X) $ze[$y] = max($ze[$y], min(40, strlen(utf8_decode($X))));
					}
				}
				echo ($Ra ? "<th>" . lang(255) : "") . "</thead>\n";
				if (is_ajax()) {
					if ($z % 2 == 1 && $D % 2 == 1) odd();
					ob_end_clean();
				}
				foreach ($b->rowDescriptions($J, $id) as $bf => $I) {
					$Ji = unique_array($J[$bf], $w);
					if (!$Ji) {
						$Ji = array();
						foreach ($J[$bf] as $y => $X) {
							if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $y)) $Ji[$y] = $X;
						}
					}
					$Ki = "";
					foreach ($Ji
							 as $y => $X) {
						if (($x == "sql" || $x == "pgsql") && preg_match('~char|text|enum|set~', $p[$y]["type"]) && strlen($X) > 64) {
							$y = (strpos($y, '(') ? $y : idf_escape($y));
							$y = "MD5(" . ($x != 'sql' || preg_match("~^utf8~", $p[$y]["collation"]) ? $y : "CONVERT($y USING " . charset($h) . ")") . ")";
							$X = md5($X);
						}
						$Ki .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($y) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($y));
					}
					echo "<tr" . odd() . ">" . (!$rd && $K ? "" : "<td>" . checkbox("check[]", substr($Ki, 1), in_array(substr($Ki, 1), (array)$_POST["check"])) . ($ce || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($a) . $Ki) . "' class='edit'>" . lang(256) . "</a>"));
					foreach ($I
							 as $y => $X) {
						if (isset($cf[$y])) {
							$o = $p[$y];
							$X = $m->value($X, $o);
							if ($X != "" && (!isset($wc[$y]) || $wc[$y] != "")) $wc[$y] = (is_mail($X) ? $cf[$y] : "");
							$_ = "";
							if (preg_match('~blob|bytea|raw|file~', $o["type"]) && $X != "") $_ = ME . 'download=' . urlencode($a) . '&field=' . urlencode($y) . $Ki;
							if (!$_ && $X !== null) {
								foreach ((array)$id[$y] as $q) {
									if (count($id[$y]) == 1 || end($q["source"]) == $y) {
										$_ = "";
										foreach ($q["source"] as $s => $Ah) $_ .= where_link($s, $q["target"][$s], $J[$bf][$Ah]);
										$_ = ($q["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($q["db"]), ME) : ME) . 'select=' . urlencode($q["table"]) . $_;
										if ($q["ns"]) $_ = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($q["ns"]), $_);
										if (count($q["source"]) == 1) break;
									}
								}
							}
							if ($y == "COUNT(*)") {
								$_ = ME . "select=" . urlencode($a);
								$s = 0;
								foreach ((array)$_GET["where"] as $W) {
									if (!array_key_exists($W["col"], $Ji)) $_ .= where_link($s++, $W["col"], $W["val"], $W["op"]);
								}
								foreach ($Ji
										 as $he => $W) $_ .= where_link($s++, $he, $W);
							}
							$X = select_value($X, $_, $o, $ii);
							$t = h("val[$Ki][" . bracket_escape($y) . "]");
							$Y = $_POST["val"][$Ki][bracket_escape($y)];
							$rc = !is_array($I[$y]) && is_utf8($X) && $J[$bf][$y] == $I[$y] && !$od[$y];
							$hi = preg_match('~text|lob~', $o["type"]);
							echo "<td id='$t'";
							if (($_GET["modify"] && $rc) || $Y !== null) {
								$wd = h($Y !== null ? $Y : $I[$y]);
								echo ">" . ($hi ? "<textarea name='$t' cols='30' rows='" . (substr_count($I[$y], "\n") + 1) . "'>$wd</textarea>" : "<input name='$t' value='$wd' size='$ze[$y]'>");
							} else {
								$De = strpos($X, "<i>…</i>");
								echo " data-text='" . ($De ? 2 : ($hi ? 1 : 0)) . "'" . ($rc ? "" : " data-warning='" . h(lang(257)) . "'") . ">$X</td>";
							}
						}
					}
					if ($Ra) echo "<td>";
					$b->backwardKeysPrint($Ra, $J[$bf]);
					echo "</tr>\n";
				}
				if (is_ajax()) exit;
				echo "</table>\n", "</div>\n";
			}
			if (!is_ajax()) {
				if ($J || $D) {
					$Fc = true;
					if ($_GET["page"] != "last") {
						if ($z == "" || (count($J) < $z && ($J || !$D))) $ld = ($D ? $D * $z : 0) + count($J); elseif ($x != "sql" || !$ce) {
							$ld = ($ce ? false : found_rows($R, $Z));
							if ($ld < max(1e4, 2 * ($D + 1) * $z)) $ld = reset(slow_query(count_rows($a, $Z, $ce, $rd))); else$Fc = false;
						}
					}
					$Rf = ($z != "" && ($ld === false || $ld > $z || $D));
					if ($Rf) {
						echo(($ld === false ? count($J) + 1 : $ld - $D * $z) > $z ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($D + 1)) . '" class="loadmore">' . lang(258) . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$z) . ", '" . lang(259) . "…');", "") : ''), "\n";
					}
				}
				echo "<div class='footer'><div>\n";
				if ($J || $D) {
					if ($Rf) {
						$Le = ($ld === false ? $D + (count($J) >= $z ? 2 : 1) : floor(($ld - 1) / $z));
						echo "<fieldset>";
						if ($x != "simpledb") {
							echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . lang(260) . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . lang(260) . "', '" . ($D + 1) . "')); return false; };"), pagination(0, $D) . ($D > 5 ? " …" : "");
							for ($s = max(1, $D - 4); $s < min($Le, $D + 5); $s++) echo
							pagination($s, $D);
							if ($Le > 0) {
								echo($D + 5 < $Le ? " …" : ""), ($Fc && $ld !== false ? pagination($Le, $D) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Le'>" . lang(261) . "</a>");
							}
						} else {
							echo "<legend>" . lang(260) . "</legend>", pagination(0, $D) . ($D > 1 ? " …" : ""), ($D ? pagination($D, $D) : ""), ($Le > $D ? pagination($D + 1, $D) . ($Le > $D + 1 ? " …" : "") : "");
						}
						echo "</fieldset>\n";
					}
					echo "<fieldset>", "<legend>" . lang(262) . "</legend>";
					$gc = ($Fc ? "" : "~ ") . $ld;
					echo
						checkbox("all", 1, 0, ($ld !== false ? ($Fc ? "" : "~ ") . lang(150, $ld) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$gc' : checked); selectCount('selected2', this.checked || !checked ? '$gc' : checked);") . "\n", "</fieldset>\n";
					if ($b->selectCommandPrint()) {
						echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"'), '><legend>', lang(254), '</legend><div>
<input type="submit" value="', lang(14), '"', ($_GET["modify"] ? '' : ' title="' . lang(250) . '"'), '>
</div></fieldset>
<fieldset><legend>', lang(126), ' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="', lang(10), '">
<input type="submit" name="clone" value="', lang(246), '">
<input type="submit" name="delete" value="', lang(18), '">', confirm(), '</div></fieldset>
';
					}
					$jd = $b->dumpFormat();
					foreach ((array)$_GET["columns"] as $e) {
						if ($e["fun"]) {
							unset($jd['sql']);
							break;
						}
					}
					if ($jd) {
						print_fieldset("export", lang(74) . " <span id='selected2'></span>");
						$Pf = $b->dumpOutput();
						echo($Pf ? html_select("output", $Pf, $za["output"]) . " " : ""), html_select("format", $jd, $za["format"]), " <input type='submit' name='export' value='" . lang(74) . "'>\n", "</div></fieldset>\n";
					}
					$b->selectEmailPrint(array_filter($wc, 'strlen'), $f);
				}
				echo "</div></div>\n";
				if ($b->selectImportPrint()) {
					echo "<div>", "<a href='#import'>" . lang(73) . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", ""), "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array("csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"), $za["format"], 1);
					echo " <input type='submit' name='import' value='" . lang(73) . "'>", "</span>", "</div>";
				}
				echo "<input type='hidden' name='token' value='$ti'>\n", "</form>\n", (!$rd && $K ? "" : script("tableCheck();"));
			}
		}
	}
	if (is_ajax()) {
		ob_end_clean();
		exit;
	}
} elseif (isset($_GET["variables"])) {
	$O = isset($_GET["status"]);
	page_header($O ? lang(118) : lang(117));
	$bj = ($O ? show_status() : show_variables());
	if (!$bj) echo "<p class='message'>" . lang(12) . "\n"; else {
		echo "<table cellspacing='0'>\n";
		foreach ($bj
				 as $y => $X) {
			echo "<tr>", "<th><code class='jush-" . $x . ($O ? "status" : "set") . "'>" . h($y) . "</code>", "<td>" . h($X);
		}
		echo "</table>\n";
	}
} elseif (isset($_GET["script"])) {
	header("Content-Type: text/javascript; charset=utf-8");
	if ($_GET["script"] == "db") {
		$Rh = array("Data_length" => 0, "Index_length" => 0, "Data_free" => 0);
		foreach (table_status() as $B => $R) {
			json_row("Comment-$B", h($R["Comment"]));
			if (!is_view($R)) {
				foreach (array("Engine", "Collation") as $y) json_row("$y-$B", h($R[$y]));
				foreach ($Rh + array("Auto_increment" => 0, "Rows" => 0) as $y => $X) {
					if ($R[$y] != "") {
						$X = format_number($R[$y]);
						json_row("$y-$B", ($y == "Rows" && $X && $R["Engine"] == ($Dh == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
						if (isset($Rh[$y])) $Rh[$y] += ($R["Engine"] != "InnoDB" || $y != "Data_free" ? $R[$y] : 0);
					} elseif (array_key_exists($y, $R)) json_row("$y-$B");
				}
			}
		}
		foreach ($Rh
				 as $y => $X) json_row("sum-$y", format_number($X));
		json_row("");
	} elseif ($_GET["script"] == "kill") $h->query("KILL " . number($_POST["kill"]));
	else {
		foreach (count_tables($b->databases()) as $l => $X) {
			json_row("tables-$l", $X);
			json_row("size-$l", db_size($l));
		}
		json_row("");
	}
	exit;
} else {
	$ai = array_merge((array)$_POST["tables"], (array)$_POST["views"]);
	if ($ai && !$n && !$_POST["search"]) {
		$G = true;
		$Qe = "";
		if ($x == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) queries("SET foreign_key_checks = 0");
		if ($_POST["truncate"]) {
			if ($_POST["tables"]) $G = truncate_tables($_POST["tables"]);
			$Qe = lang(263);
		} elseif ($_POST["move"]) {
			$G = move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
			$Qe = lang(264);
		} elseif ($_POST["copy"]) {
			$G = copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
			$Qe = lang(265);
		} elseif ($_POST["drop"]) {
			if ($_POST["views"]) $G = drop_views($_POST["views"]);
			if ($G && $_POST["tables"]) $G = drop_tables($_POST["tables"]);
			$Qe = lang(266);
		} elseif ($x != "sql") {
			$G = ($x == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"]));
			$Qe = lang(267);
		} elseif (!$_POST["tables"]) $Qe = lang(9);
        elseif ($G = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
			while ($I = $G->fetch_assoc()) $Qe .= "<b>" . h($I["Table"]) . "</b>: " . h($I["Msg_text"]) . "<br>";
		}
		queries_redirect(substr(ME, 0, -1), $Qe, $G);
	}
	page_header(($_GET["ns"] == "" ? lang(38) . ": " . h(DB) : lang(78) . ": " . h($_GET["ns"])), $n, true);
	if ($b->homepage()) {
		if ($_GET["ns"] !== "") {
			echo "<h3 id='tables-views'>" . lang(268) . "</h3>\n";
			$Zh = tables_list();
			if (!$Zh) echo "<p class='message'>" . lang(9) . "\n"; else {
				echo "<form action='' method='post'>\n";
				if (support("table")) {
					echo "<fieldset><legend>" . lang(269) . " <span id='selected2'></span></legend><div>", "<input type='search' name='query' value='" . h($_POST["query"]) . "'>", script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", ""), " <input type='submit' name='search' value='" . lang(57) . "'>\n", "</div></fieldset>\n";
					if ($_POST["search"] && $_POST["query"] != "") {
						$_GET["where"][0]["op"] = "LIKE %%";
						search_tables();
					}
				}
				echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""), '<th>' . lang(131), '<td>' . lang(270) . doc_link(array('sql' => 'storage-engines.html')), '<td>' . lang(122) . doc_link(array('sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/')), '<td>' . lang(271) . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT', 'oracle' => 'REFRN20286')), '<td>' . lang(272) . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')), '<td>' . lang(273) . doc_link(array('sql' => 'show-table-status.html')), '<td>' . lang(52) . doc_link(array('sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/')), '<td>' . lang(274) . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'catalog-pg-class.html#CATALOG-PG-CLASS', 'oracle' => 'REFRN20286')), (support("comment") ? '<td>' . lang(51) . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')) : ''), "</thead>\n";
				$S = 0;
				foreach ($Zh
						 as $B => $T) {
					$ej = ($T !== null && !preg_match('~table~i', $T));
					$t = h("Table-" . $B);
					echo '<tr' . odd() . '><td>' . checkbox(($ej ? "views[]" : "tables[]"), $B, in_array($B, $ai, true), "", "", "", $t), '<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($B) . "' title='" . lang(43) . "' id='$t'>" . h($B) . '</a>' : h($B));
					if ($ej) {
						echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($B) . '" title="' . lang(44) . '">' . (preg_match('~materialized~i', $T) ? lang(129) : lang(130)) . '</a>', '<td align="right"><a href="' . h(ME) . "select=" . urlencode($B) . '" title="' . lang(42) . '">?</a>';
					} else {
						foreach (array("Engine" => array(), "Collation" => array(), "Data_length" => array("create", lang(45)), "Index_length" => array("indexes", lang(133)), "Data_free" => array("edit", lang(46)), "Auto_increment" => array("auto_increment=1&create", lang(45)), "Rows" => array("select", lang(42)),) as $y => $_) {
							$t = " id='$y-" . h($B) . "'";
							echo($_ ? "<td align='right'>" . (support("table") || $y == "Rows" || (support("indexes") && $y != "Data_length") ? "<a href='" . h(ME . "$_[0]=") . urlencode($B) . "'$t title='$_[1]'>?</a>" : "<span$t>?</span>") : "<td id='$y-" . h($B) . "'>");
						}
						$S++;
					}
					echo(support("comment") ? "<td id='Comment-" . h($B) . "'>" : "");
				}
				echo "<tr><td><th>" . lang(247, count($Zh)), "<td>" . h($x == "sql" ? $h->result("SELECT @@storage_engine") : ""), "<td>" . h(db_collation(DB, collations()));
				foreach (array("Data_length", "Index_length", "Data_free") as $y) echo "<td align='right' id='sum-$y'>";
				echo "</table>\n", "</div>\n";
				if (!information_schema(DB)) {
					echo "<div class='footer'><div>\n";
					$Yi = "<input type='submit' value='" . lang(275) . "'> " . on_help("'VACUUM'");
					$Af = "<input type='submit' name='optimize' value='" . lang(276) . "'> " . on_help($x == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
					echo "<fieldset><legend>" . lang(126) . " <span id='selected'></span></legend><div>" . ($x == "sqlite" ? $Yi : ($x == "pgsql" ? $Yi . $Af : ($x == "sql" ? "<input type='submit' value='" . lang(277) . "'> " . on_help("'ANALYZE TABLE'") . $Af . "<input type='submit' name='check' value='" . lang(278) . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . lang(279) . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . lang(280) . "'> " . on_help($x == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($x == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . lang(127) . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
					$k = (support("scheme") ? $b->schemas() : $b->databases());
					if (count($k) != 1 && $x != "sqlite") {
						$l = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
						echo "<p>" . lang(281) . ": ", ($k ? html_select("target", $k, $l) : '<input name="target" value="' . h($l) . '" autocapitalize="off">'), " <input type='submit' name='move' value='" . lang(282) . "'>", (support("copy") ? " <input type='submit' name='copy' value='" . lang(283) . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], lang(284)) : ""), "\n";
					}
					echo "<input type='hidden' name='all' value=''>";
					echo
					script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }"), "<input type='hidden' name='token' value='$ti'>\n", "</div></fieldset>\n", "</div></div>\n";
				}
				echo "</form>\n", script("tableCheck();");
			}
			echo '<p class="links"><a href="' . h(ME) . 'create=">' . lang(75) . "</a>\n", (support("view") ? '<a href="' . h(ME) . 'view=">' . lang(204) . "</a>\n" : "");
			if (support("routine")) {
				echo "<h3 id='routines'>" . lang(143) . "</h3>\n";
				$bh = routines();
				if ($bh) {
					echo "<table cellspacing='0'>\n", '<thead><tr><th>' . lang(183) . '<td>' . lang(50) . '<td>' . lang(221) . "<td></thead>\n";
					odd('');
					foreach ($bh
							 as $I) {
						$B = ($I["SPECIFIC_NAME"] == $I["ROUTINE_NAME"] ? "" : "&name=" . urlencode($I["ROUTINE_NAME"]));
						echo '<tr' . odd() . '>', '<th><a href="' . h(ME . ($I["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($I["SPECIFIC_NAME"]) . $B) . '">' . h($I["ROUTINE_NAME"]) . '</a>', '<td>' . h($I["ROUTINE_TYPE"]), '<td>' . h($I["DTD_IDENTIFIER"]), '<td><a href="' . h(ME . ($I["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($I["SPECIFIC_NAME"]) . $B) . '">' . lang(136) . "</a>";
					}
					echo "</table>\n";
				}
				echo '<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . lang(220) . '</a>' : '') . '<a href="' . h(ME) . 'function=">' . lang(219) . "</a>\n";
			}
			if (support("sequence")) {
				echo "<h3 id='sequences'>" . lang(285) . "</h3>\n";
				$ph = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");
				if ($ph) {
					echo "<table cellspacing='0'>\n", "<thead><tr><th>" . lang(183) . "</thead>\n";
					odd('');
					foreach ($ph
							 as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "sequence=" . urlencode($X) . "'>" . h($X) . "</a>\n";
					echo "</table>\n";
				}
				echo "<p class='links'><a href='" . h(ME) . "sequence='>" . lang(226) . "</a>\n";
			}
			if (support("type")) {
				echo "<h3 id='user-types'>" . lang(26) . "</h3>\n";
				$Wi = types();
				if ($Wi) {
					echo "<table cellspacing='0'>\n", "<thead><tr><th>" . lang(183) . "</thead>\n";
					odd('');
					foreach ($Wi
							 as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "type=" . urlencode($X) . "'>" . h($X) . "</a>\n";
					echo "</table>\n";
				}
				echo "<p class='links'><a href='" . h(ME) . "type='>" . lang(230) . "</a>\n";
			}
			if (support("event")) {
				echo "<h3 id='events'>" . lang(144) . "</h3>\n";
				$J = get_rows("SHOW EVENTS");
				if ($J) {
					echo "<table cellspacing='0'>\n", "<thead><tr><th>" . lang(183) . "<td>" . lang(286) . "<td>" . lang(210) . "<td>" . lang(211) . "<td></thead>\n";
					foreach ($J
							 as $I) {
						echo "<tr>", "<th>" . h($I["Name"]), "<td>" . ($I["Execute at"] ? lang(287) . "<td>" . $I["Execute at"] : lang(212) . " " . $I["Interval value"] . " " . $I["Interval field"] . "<td>$I[Starts]"), "<td>$I[Ends]", '<td><a href="' . h(ME) . 'event=' . urlencode($I["Name"]) . '">' . lang(136) . '</a>';
					}
					echo "</table>\n";
					$Dc = $h->result("SELECT @@event_scheduler");
					if ($Dc && $Dc != "ON") echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($Dc) . "\n";
				}
				echo '<p class="links"><a href="' . h(ME) . 'event=">' . lang(209) . "</a>\n";
			}
			if ($Zh) echo
			script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
		}
	}
}
page_footer();