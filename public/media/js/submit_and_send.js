"use strict";

(function( $ ){
    var lContainer = {
        counter: 0,
        gather: function(aElement)
        {
            var
                lValue     = aElement.val(),
                lIsValid   = false,
                lLength    = lValue ? lValue.length : 0,
                lFieldName = aElement.attr("name"),
                //lType    = aElement.attr("valueType"),
                lFieldType = aElement.attr("type") || aElement.prop('tagName').toLowerCase(),
                lResult    = {};

            if (!lFieldName) {

                alert('Field not have name');
                return;
            }

            lFieldType = lFieldType.toLowerCase();

            /*if ((lType === 'date') && lLength)
            {
                lValue = lValue.replace(/\//g, ".");//!! datepicker bug
                aElement.val(lValue);
            }*/

            switch(lFieldType)
            {
                case 'file':
                    if(!aElement[0].files && !aElement[0].value)
                        break;
                    lValue = aElement[0].files[0];
                    lIsValid = true;
                    break;
                case 'checkbox':
                    if (aElement.prop('checked'))
                        lIsValid = true;
                    break;
                case 'radio':
                    if(aElement.prop('checked'))
                        lIsValid = true;
                    break;
                case 'text':
                    if (lLength > 0)
                        lIsValid = true;
                    break;
                default:
                    if (lLength > 0)
                        lIsValid = true;
                    break;
            }

            if (!lIsValid)
                return lResult;

            var lTemp = lFieldName.split('['),
                lSize = 0,
                lFlag = null,
                TemporaryObj = {};

            if (!lTemp[0])
                lTemp.splice(0, 1);

            for (lSize = lTemp.length; lSize--; ) {
                TemporaryObj = {};
                if (lTemp[lSize] == ']')
                    lTemp[lSize] = lContainer.counter++;
                else
                    lTemp[lSize] = lTemp[lSize].replace(']','');

                if (lFlag) {
                    TemporaryObj[lTemp[lSize]] = lResult;
                    lResult = TemporaryObj;
                }
                else {
                    lResult[lTemp[lSize]] = lValue;
                    lFlag = true;
                }
            }
            return lResult;
        }
    };

    var lHelper = {
        setLoader: function(aElement, aIsLoading) {
            aIsLoading
                ? aElement.addClass('sys_disabled')
                : aElement.removeClass('sys_disabled');
        },

        isLoading: function(aElement) {
            return aElement.hasClass('sys_disabled');
        }
    };

    $.fn.dataGather = function (aClassID) {

        var lForm = this;

        if (!lForm) {
            alert('Invalid form');
            return;
        }

        var lList     =  aClassID.split(' '),
            lElements =  null,
            lResult   = {},
            k         = 0,
            lSize_2   = 0;

        for (var lSize = lList.length, n = 0; n < lSize; n++) {
            lElements = lForm.find('.' + lList[n]);

            for (lSize_2 = lElements.length, k = 0; k < lSize_2; k++) {
                //Object.assign(lResult, lContainer.gather($(lElements[k]), lResult));
                $.extend(true, lResult, lContainer.gather($(lElements[k])));
            }
        }
        return lResult;
    };

    $.fn.simpleSend = function(aData, aUrl, aOnSuccess, aOnError) {
        var lButton = this;
        if (!lButton || !aData || !aUrl) {
            alert('invalid params');
            return;
        }

        if (lHelper.isLoading(lButton))
            return;

        lHelper.setLoader(lButton, true);
        $.ajax({
            url: aUrl,
            data: aData,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                lHelper.setLoader(lButton, false);
                if (aOnSuccess)
                    aOnSuccess(data);
            },
            error: function(data) {
                lHelper.setLoader(lButton, false);
                if (aOnError)
                    aOnError(data);
            }
        });
    };

})( jQuery );
