function refreshProjectItems()
{
    $.getJSON("/project/getproject",
            {  
                "pid" : projectId
            },
            function(data) 
            {	
                if(response["responseCode"]=="200")
                {                                            
                    console.log(data);
                }
                else
                {
                        addNotification("Error refreshing project", response["messages"], false, 3000);
                }                                    
            }
    );
}

$(function(){
	
	var dropbox = $('#dropbox'),
		message = $('.message', dropbox);
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'pic',
		maxfiles: 5,
                maxfilesize: 20,
		url: '/project/uploadimage',
		
		uploadFinished:function(i,file,response){
                    
                        filesUploaded=filesUploaded+1;
                        console.log("Response for "+i+" number of files is "+numFiles);
                        if(response["responseCode"]=="200")
                        {
                                $.data(file).addClass('done');
                                addNotification("File Uploaded", "File "+file.name+" has been uploaded succesfully", false, 3000);
                        }
                        else
                        {
                                addNotification("File upload problem", response["messages"], false, 3000);
                        }
			
                        
                        if(filesUploaded==numFiles)
                        {
                            console.log("All files have been uploaded, refreshing project info.");
                            refreshProjectItems();
                            filesUploaded=0;
                            numFiles=0;
                        }
			// response is the JSON object that post_file.php returns
		},
		
                error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
                                        addNotification("File Upload Problem", 'Your browser does not support HTML5 file uploads!', false, 3000);
					break;
				case 'TooManyFiles':
                                        addNotification("File Upload Problem", 'Too many files! Please select 5 at most!', false, 3000);
					break;
				case 'FileTooLarge':
                                        addNotification("File Upload Problem", file.name+' is too large! Please upload files up to 20mb.', false, 3000);
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
                                addNotification("File Upload Problem", 'Only images are allowed!', false, 3000);        
				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
		},
		
		progressUpdated: function(i, file, progress) {
                        console.log("progress");
			$.data(file).find('.progress').width(progress);
		}
    	 
	});
	
        
        	
	
	function createImage(file){
            numProjectImages=numProjectImages+1;
                addNotification("Uploading file", 'File "'+file.name+'" has begun uploading as image number "'+numProjectImages+'"', false, 5000);                
                var template='<li id="img_'+numProjectImages+'" class="sortablelist">'+
                        '<div class="id_holder">'+
                        '<div id="txt_id_'+numProjectImages+'" style="display:inline-block; float:left;" class="class="txt_image_id"">'+numProjectImages+'</div>'+
                        '<div style="display:inline-block; float:right;"><input id="chk_proj_'+numProjectImages+'" type="checkbox"/></div>'+
                        '</div>'+
                        '<div class="proj_img_holder">'+
                        '<div class="proj_image_wrapper">'+
                        '        <img class="image_project"/>'+
                        '</div>'+
                    '</div><div class="progress"></div>'+
                '</li>';
		var preview = $(template), 
			image = $('img', preview);
			
		var reader = new FileReader();		
		
		reader.onload = function(e){
                        var img = new Image();
                        img.src = e.target.result;
                        image.width = img.width;
                        image.height = img.height;              			
			// e.target.result holds the DataURL which
			// can be used as a source of the image:			
			image.attr('src',e.target.result);

                        
		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);
		
		message.hide();
		preview.appendTo($("#allImagesHolder"));
		
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
                $("#sortable").sortable("refresh");
	}
});