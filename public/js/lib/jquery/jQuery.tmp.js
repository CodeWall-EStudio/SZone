;(function($){
    var jTemplate = function(str, data){
        /*!
         * jstemplate: a light & fast js tamplate engine
         * License MIT (c) ᯰ�
         *
         * Modify by azrael @ 2012/9/28
         */
        var //global = typeof window != 'undefined' ? window : {},
            openTag = '<%',
            closeTag = '%>',
            retTag = '$return',
            vars = 'var ',
            varsInTpl,
            codeArr = ''.trim ?
                [retTag + ' = "";', retTag + ' +=', ';', retTag + ';', 'print=function(){' + retTag + '+=[].join.call(arguments,"")},'] :
                [retTag + ' = [];', retTag + '.push(', ')', retTag + '.join("");', 'print=function(){' + retTag + '.push.apply(arguments)},'],
            keys = ('break,case,catch,continue,debugger,default,delete,do,else,false,finally,for,function,if'
                + ',in,instanceof,new,null,return,switch,this,throw,true,try,typeof,var,void,while,with'
                // Reserved words
                + ',abstract,boolean,byte,char,class,const,double,enum,export,extends,final,float,goto'
                + ',implements,import,int,interface,long,native,package,private,protected,public,short'
                + ',static,super,synchronized,throws,transient,volatile'

                // ECMA 5 - use strict
                + ',arguments,let,yield').split(','),
            keyMap = {};

        for (var i = 0, len = keys.length; i < len; i ++) {
            keyMap[keys[i]] = 1;
        }

        function _getCompileFn (source) {
            vars = 'var ';
            varsInTpl = {};
            varsInTpl[retTag] = 1;
            var openArr = source.split(openTag),
                tmpCode = '';

            for (var i = 0, len = openArr.length; i < len; i ++) {
                var c = openArr[i],
                    cArr = c.split(closeTag);
                if (cArr.length == 1) {
                    tmpCode += _html(cArr[0]);
                } else {
                    tmpCode += _js(cArr[0]);
                    tmpCode += cArr[1] ? _html(cArr[1]) : '';
                }
            }

            var code = vars + codeArr[0] + tmpCode + 'return ' + codeArr[3];
            var fn = new Function('$data', code);

            return fn;
        }

        function _html (s) {
            s = s
                .replace(/('|"|\\)/g, '\\$1')
                .replace(/\r/g, '\\r')
                .replace(/\n/g, '\\n');

            s = codeArr[1] + '"' + s + '"' + codeArr[2];

            return s + '\n';
        }

        function _js (s) {
            if (/^=/.test(s)) {
                s = codeArr[1] + s.substring(1).replace(/[\s;]*$/, '') + codeArr[2];
            }
            dealWithVars(s);

            return s + '\n';
        }

        function dealWithVars (s) {
            s = s.replace(/\/\*.*?\*\/|'[^']*'|"[^"]*"|\.[\$\w]+/g, '');
            var sarr = s.split(/[^\$\w\d]+/);
            for (var i = 0, len = sarr.length; i < len; i ++) {
                var c = sarr[i];
                if (!c || keyMap[c] || /^\d/.test(c)) {
                    continue;
                }
                if (!varsInTpl[c]) {
                    if (c === 'print') {
                        vars += codeArr[4];
                    } else {
                        vars += (c + '=$data.hasOwnProperty("'+c+'")?$data.' + c + ':window.' + c + ',');
                    }
                    varsInTpl[c] = 1;
                }
            }
        }


        var cache = {};
        return function(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.
            var fn = !/\W/.test(str) ?
                cache[str] || (cache[str] = _getCompileFn(document.getElementById(str).innerHTML)) :
                _getCompileFn(str);

            // Provide some basic currying to the user
            return data ? fn(data) : fn;
        };
    }();
    $.tmp = jTemplate;
})(jQuery);
