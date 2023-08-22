$('.dropify').dropify({
	messages: {
		'default': trans('Drag and drop a file here or click'),
		'replace': trans('Drag and drop or click to replace'),
		'remove': trans('Remove'),
		'error': trans('Ooops, something wrong appended.')
	},
	error: {
		'fileSize': trans('The file size is too big (2M max).')
	}
});
	
