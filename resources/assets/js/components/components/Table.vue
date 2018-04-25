<template>
	<table class="table">
		<thead>
			<tr>
				<slot name="thead"></slot>
			</tr>
		</thead>
		<tbody id="tbody">
			<slot name ="tbody"></slot>
		</tbody>
	</table>
</template>