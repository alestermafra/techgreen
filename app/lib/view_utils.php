<?php

function fn_sn(bool $x) { // função que retorna VISTO-CHECK-FEITO ou NÃO-NONE-CLEAR
	if($x) {
		return '<i class="tiny material-icons text-success">check</i>';
	}
	return '<i class="tiny material-icons text-danger">clear</i>';
}