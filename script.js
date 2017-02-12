function selection(img) {
	selection.img = (img === selection.img) ? null : img;
}

function getSnapLikes(snap, cb) {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			cb(http.responseText);
			console.log (http.responseText + " likes - " + snap);
		}
	}
	http.send("getSnapLikes=" + snap);
}

function likeSnap(snap) {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			console.log (http.responseText + " liked :" + snap);
		}
	}
	http.send("likeSnap=" + snap);
}

function commentSnap(comment, snap) {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		console.log(http.responseText);
		if (http.readyState == 4 && http.status == 200) {
			console.log ("comment :" + comment + "   snap:" + snap);
		}
	}
	http.send("commentSnap=" + comment + "&snap_file=" + snap);
}

function getComments(snap, cb) {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			var ret = document.createElement ('div');
			var img = document.createElement ('img');
			img.src = "photos/" + snap;
			img.style = 'width: 100%;';
			ret.appendChild(img);
			var comments = JSON.parse(http.responseText);
			for (var key in comments) {
				(function (comment) {
					var com = document.createElement('p');
					com.innerHTML = "[" + comments[key]['timestamp'] + "] <b>"
						+ comments[key]['login'] + "</b>: "
						+ comments[key]['comment'];
					ret.appendChild(com);
				})(comments[key]);
			}
			var likes = document.createElement('p');
			getSnapLikes (snap, function (likes_nb) {
				likes.innerHTML = likes_nb + (likes_nb == 1 ? " like" : " likes");
			});
			ret.appendChild(likes);

			var input = t_comment.cloneNode(true);
			input.querySelector("#submit").onclick = function()
			{commentSnap(input.querySelector("#comment").value, snap);
				window.location.reload();};
			ret.appendChild(input);
			cb(ret);
		}
	}
	http.send("getComments=" + snap);
}

function loadSnapshots(logged) {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			console.log(http.responseText);
			var snaps = JSON.parse(http.responseText);
			for (var key in snaps) {

				(function (snap) {
					var snap_box = document.createElement('div');
					snap_box.classList.add ("snap_box");

					var new_snap = document.createElement('img');
					new_snap.style = "width: 100%";
					new_snap.src = "photos/" + snap;

					snap_box.appendChild (new_snap);

					if (logged)
					{
						var nb_like = document.createElement('p');
						getSnapLikes(snap, function (likes_nb) {
							nb_like.innerHTML = likes_nb + (likes_nb == 1 ? " like" : " likes");
						});

						snap_box.appendChild (nb_like);

						var comments = document.createElement('button');
						comments.innerHTML = "Comments";
						comments.onclick = function(){window.location = "index.php?snap=" + snap};

						snap_box.appendChild (comments);

						var like = document.createElement('button');
						like.innerHTML = "Like";
						like.addEventListener("click", function(){likeSnap(snap)});
						snap_box.appendChild (like);
					}

					document.getElementById('snapshots').appendChild(snap_box);

				}) (snaps[key]);
			}
		}
	}
	http.send("snapshots=1");
}

function loadUserSnaps() {
	var http = new XMLHttpRequest();
	http.open("POST", "snap.php", true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			var snaps = JSON.parse(http.responseText);
			for (var key in snaps) {

				var new_snap = document.createElement('img');
				new_snap.style = "width: 100%";
				new_snap.src = "photos/" + snaps[key];

				document.getElementById('snapshots').appendChild(new_snap);
			}
		}
	}
	http.send("user_snaps=1");
}

function useTemplate(template, id) {
	var normalContent = document.getElementById(id);
	normalContent.innerHTML = '';
	normalContent.appendChild(template);
	var arr = template.getElementsByTagName('script')
	for (var n = 0; n < arr.length; n++)
		eval(arr[n].innerHTML);
}

function useCamera() {
	window.addEventListener("DOMContentLoaded", function() {
		var video = document.getElementById("video");

		navigator.getMedia = (navigator.getUserMedia ||
			navigator.webkitGetUserMedia ||
				navigator.mozGetUserMedia ||
				navigator.msGetUserMedia);

		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
				}
				video.play();
			},
			function(err) {
				console.log("ERROR: " + err);
			}
		);

		video.play();
		//}, Log_Err);

		document.getElementById("snap").addEventListener("click", function() {
			if (selection.img === null || selection.img === undefined) {
				alert("Please click on an image");
			} else {
				var canvas = document.querySelector('canvas');
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;

				canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

				var http = new XMLHttpRequest();
				http.open("POST", "snap.php", true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.onreadystatechange = function() {
					if (http.readyState == 4 && http.status == 200) {
						var new_snap = document.createElement('img');
						new_snap.src = http.responseText;
						new_snap.style = "width: 100%";
						var snapshots = document.getElementById('snapshots');
						snapshots.insertBefore(new_snap, snapshots.childNodes[0]);
					}
				}
				http.send("snap=" + encodeURIComponent(canvas.toDataURL('image/png')) + "&img=" + selection.img);
			}
		});
	}, false);
}
