function useTemplate(template, id) {
    var templatesImport = document.getElementById('templates');
    var templates = templatesImport.import;
    var myTemplate = templates.getElementById(template),
    normalContent = document.getElementById(id),
    clonedTemplate = myTemplate.content.cloneNode(true);
    normalContent.innerHTML = '';
    normalContent.appendChild(clonedTemplate);
}

function useCamera() {
  window.addEventListener("DOMContentLoaded", function() {
  	//var canvas = document.getElementById("canvas"),
  	//context = canvas.getContext("2d"),

  		var video = document.getElementById("video"),
  		videoObj = { "video": true },
  		errBack = function(error) {
  			console.log("Video capture error: ", error.code);
  		};

  	if (navigator.getUserMedia) {
  		navigator.getUserMedia(videoObj, function(stream) {
  			video.src = stream;
  			video.play();
  		}, errBack);
  	} else if(navigator.webkitGetUserMedia) {
  		navigator.webkitGetUserMedia(videoObj, function(stream){
  			video.src = window.URL.createObjectURL(stream);
  			video.play();
  		}, errBack);
  	}
  	else if(navigator.mozGetUserMedia || navigator.webkitGetUserMedia) {
  		navigator.mozGetUserMedia(videoObj, function(stream){
  			video.src = window.URL.createObjectURL(stream);
  			video.play();
  		}, errBack);
  	}
    //document.getElementById("snap").addEventListener("click", function() {
      //context.drawImage(video, 0, 0, 640, 480);
    //});
  }, false);
}
