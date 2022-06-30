function showProcessingOverlay() {
	for (var e = $(document).height(), c = ($(document).width(), 1); c <= 9; c++) "<div class='sk-cube sk-cube" + c + "'></div>";
		$("body").append('<div class="se-pre-con"></div>'), $(".se-pre-con").css({
			opacity: .6,
			'text-align': 'center',
			'vertical-align': 'middle',
			"background-color": "white",
			'margin': 'auto',
			'top': 0,
			'left': 0,
			"z-index": 999999
		})
}

function hideProcessingOverlay() {
	$(".se-pre-con").remove()
}
 function checkType(e) 
    {
        return e.split(";")[0].split("/")[1]
    }

    function checkSize(e) 
    {
        var t = e.length - "data:image/png;base64,".length;
        return 4 * Math.ceil(t / 3) * .5624896334383812 / 1e3
    }
    
    $(document).ready(function() 
    {
        var e = document.getElementById("logo"),
            t = "{{ url('/front') }}/images/add-logo.png";
        
        $(e).change(function() 
        {
            
            if (e.files && e.files[0]) 
            {
                var a = e.files,
                    n = a[0].name.substring(a[0].name.lastIndexOf(".") + 1),
                    r = new FileReader;
                
                if ("JPEG" != n && "jpeg" != n && "jpg" != n && "JPG" != n && "png" != n && "PNG" != n) return showAlert("Sorry, " + a[0].name + " is invalid, allowed extensions are: jpeg , jpg , png", "error"), $(".image-logo").attr("src", t), !1;
                
                if (a[0].size > 2e6) return showAlert("Sorry, " + a[0].name + " is invalid, Image size should be upto 2 MB only", "error"), $("#logo").val(""), $(".image-logo").attr("src", t), !1;
                
                r.onload = function(e) 
                {
                    var a = new Image;
                    
                    a.src = e.target.result, a.onload = function() {
                        var e = this.height,
                            a = this.width;
                        
                        if (e < 120 || a < 120) return showAlert("Sorry,Please upload image with Height and Width greater than or equal to 120 X 120 for best result", "error"), $("#logo").val(""), $(".image-logo").attr("src", t), !1
                    }, 

                    $(".image-logo").attr("src", e.target.result)
                
                }, r.readAsDataURL(e.files[0])
            }
        })
    }),
    function(e) 
    {
        var t = e("span[data-multiupload]");
        
        t.length > 0 && e.each(t, function(t, a) 
        {
            var n = e(a).attr("data-multiupload"),
                r = "multiupload_img_" + n + "_",
                o = "multiupload_img_remove" + n + "_",
                i = r + "_file",
                l = "data-multiupload-src-" + n,
                s = "data-multiupload-holder-" + n,
                u = "data-multiupload-fileinputs-" + n,
                d = e(a).find("input[data-multiupload-src]");
            
            e(d).removeAttr("data-multiupload-src").attr(l, "");
            
            var c = e(a).find("span[data-multiupload-holder]");
            
            e(c).removeAttr("data-multiupload-holder").attr(s, "");

            var m = e(a).find("span[data-multiupload-fileinputs]");
            
            e(m).removeAttr("data-multiupload-fileinputs").attr(u, ""), e(d).on("change", function(t) 
            {
                showProcessingOverlay();
                setTimeout(function() 
                {
                    hideProcessingOverlay()
                }, 600)
                var a, n;
                a = t.target, n = function(t, a) 
                {
                    0 == t && function(t) 
                    {
                        if (e(".upload_pic_btn").val(""), g > 5) return showAlert("Sorry, only 5 images are allowed to upload.", "error"), !1;
                        
                        var a = checkType(t);
                        
                        if ("jpeg" != a && "jpg" != a && "png" != a && "gif" != a) return showAlert("Sorry,Please upload image with extension png, jpg, jpeg, gif.", "error"), !1;
                        
                        if (!(2e3 > checkSize(t))) return showAlert("Sorry, Image size should be upto 2 MB only.", "error"), !1;
                        
                        var n, l = Math.random().toString(36).substring(2, 10),
                        
                        s = '<div class="upload-photo" id="' + r + l + '"><span class="upload-close"><a href="javascript:void(0)" id="' + o + l + '" ><i class="fal fa-trash"></i></a></span><img class="upload-img" src="' + t + '" ></div>',
                        u = '<input type="text" name="file[]" id="' + i + l + '"  value="' + t + '" />';
                        
                        e(c).append(s), e(m).append(u), e("#" + o + (n = l)).on("click", function() 
                        {    
                            e("#" + r + n).remove(), e("#" + i + n).remove(), g--
                        }), g++
                    }(a)
                }, a.files && e.each(a.files, function(e, t) 
                {
                    var a = new FileReader;
                    a.onload = function(e) 
                    {
                        n(!1, e.target.result)
                    }, a.readAsDataURL(t)
                }), n(!0, !1)
            });
            var g = 1
        })
    }(jQuery)