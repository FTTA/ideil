'use strict';

window.fileUploader = function(aOptions)
{
    var self = this,
        params = {
            entryField:  $(aOptions.entry_field),
            container:   $(aOptions.container),
            namePrefix:  (aOptions.name_prefix) ? aOptions.name_prefix : null,
            template:    $(aOptions.template).html(),
            handlerFile: aOptions.handler_file,
            sendMethod:  'POST',
            limit: (aOptions.limit) ? aOptions.limit : 0,
            counter: (aOptions.counter) ? aOptions.counter : 0,
            unicPart: (aOptions.counter) ? aOptions.counter : 0,
            additionalData: (aOptions.additionalData) ? aOptions.additionalData : null,
        },

        progressViewer = aOptions.progress_viewer ? aOptions.progress_viewer : null,

        fileInfo = {
            fileSize: null,
            filePath: null,
            fileName: null
        };

    function counterDecrement()
    {
        if (params.counter > 0)
                params.counter--;
    }

    function completeHandler(event)
    {
        if (!params.template)
            return;
        params.unicPart++;
        params.counter++;
        // --file_path--
        // --file_size--
        // --file_name--
        // --file_delete--

        // --name_prefix--

        // --file_unic--

        var lResponse = JSON.parse(event.target.responseText);
        if (!lResponse || !lResponse['file_path']) {
            alert('Uploadig of file was failed');
            return;
        }
        fileInfo.filePath = lResponse['file_path'];

        var lTemp = params.template;
        lTemp = lTemp.replace(new RegExp('--file_path--', 'gi'), fileInfo.filePath);
        lTemp = lTemp.replace(new RegExp('--file_size--', 'gi'), fileInfo.fileSize);
        lTemp = lTemp.replace(new RegExp('--file_name--', 'gi'), fileInfo.fileName);
        lTemp = lTemp.replace(new RegExp('--file_unic--', 'gi'), params.unicPart);
        lTemp = lTemp.replace(new RegExp('--name_prefix--', 'gi'), params.namePrefix);

        lTemp = $(lTemp)
        lTemp.addClass('--container_item--');

        params.container.append(lTemp);
    }

    function errorHandler(event)
    {

    }

    function progressHandler(event)
    {
        if (!progressViewer)
            return;

        progressViewer({
            bytes: {uploaded: event.loaded, total: event.total},
            percents: Math.round((event.loaded / event.total) * 100)
        });
    }

    function abortHandler(event)
    {

    }

    function uploadFile()
    {
        if ((params.limit > 0) && (params.counter >= params.limit))
            return;

        var lFormData = new FormData(),
            lTemp;

        lFormData.append(
            'files_to_load',
            params.entryField[0].files[0] // alert(file.name+" | "+file.size+" | "+file.type););
        );

        if (Object.keys(params.additionalData).length > 0) {
            for (lTemp in params.additionalData) {
                lFormData.append(lTemp, params.additionalData[lTemp]);
            }
        }

        fileInfo.fileSize = params.entryField[0].files[0].size;
        fileInfo.fileName = params.entryField[0].value;

        var lTemp = new XMLHttpRequest();
        lTemp.upload.addEventListener('progress', progressHandler, false);

        lTemp.addEventListener('load',  completeHandler, false);
        lTemp.addEventListener('error', errorHandler,    false);
        lTemp.addEventListener('abort', abortHandler,    false);
        lTemp.open(params.sendMethod, params.handlerFile);
        lTemp.send(lFormData);
    }

    function _constructor()
    {
        params.container.on('click', '.--file_delete--', function() {
            $(this).closest('.--container_item--').remove();
            counterDecrement();
        });

        self.uploadFile = uploadFile;
        self.counterDecrement = counterDecrement;

        return self;
    }

    return _constructor();
}
