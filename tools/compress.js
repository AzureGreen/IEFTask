const compressPic = (fileObj) => {
    return new Promise((resolve, reject) => {

        var fileReader = new FileReader(),
            img = new Image(),
            canvas = document.createElement('canvas'),     // 压缩图片canvas
            context = canvas.getContext('2d'),
            dataURL = null;
            
        // base64格式图片加载完成
        img.onload = event => {

            let originalWidth = img.width,
                originalHeight = img.height,
                maxWidth = 400,      // 400 * 400
                maxHeight = 400;
                canvas.width = originalWidth,
                canvas.height = originalHeight;
            if (originalWidth > maxWidth || originalHeight > maxHeight) {
                // 超过 400 * 400 限制了
                if (originalWidth / originalHeight > maxWidth / maxHeight) {
                    // wider
                    canvas.width = maxWidth;
                    canvas.height = Math.round(maxWidth * (originalHeight / originalWidth));  // 已知宽比例算出高
                } else {
                    // heighter
                    canvas.height = maxHeight;
                    canvas.width = Math.round(maxHeight * (originalWidth / originalHeight));  // 已知高比例算出宽
                }
            }
            // canvas画图
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(img, 0, 0, canvas.width, canvas.height);  // 压缩
            // 
            dataURL = canvas.toDataURL('image/jpeg');    
            resolve(dataURL);
        }

        // base64化 获得原图尺寸，按比例压缩
        fileReader.onload = event => {
            img.src = event.target.result;
        }

        var allowedFileType = '.jpg,.gif,.bmp,.png, .jpeg',
            fileExt = fileObj.name.substr(fileObj.name.lastIndexOf('.')).toLowerCase();

        // 简单判断下文件类型(img)
        if (allowedFileType.indexOf(fileExt) >= 0 && fileObj.type.indexOf('image') == 0) {
            
            fileReader.readAsDataURL(fileObj);
        }
    });
}

export default compressPic;