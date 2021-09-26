<?php

function vertical_align ($text) {
	return vertical_align_start().$text.vertical_align_end();
}
function vertical_align_start () {
	return '
	<div style="display:table;width:100%;height:100%;">
		<div style="display:table-cell;vertical-align:middle;">
	';
}
function vertical_align_end () {
	return '
		</div>
	</div>
	';
}
