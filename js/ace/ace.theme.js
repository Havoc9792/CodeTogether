ace.define("ace/theme/monokai",["require","exports","module","ace/lib/dom"], function(require, exports, module) {

exports.isDark = false;
exports.cssClass = "ace-monokai";
exports.cssText = "\
.ace-monokai .ace_gutter {\
background: #e8e8e8;\
color: #333\
}\
.ace-monokai .ace_print-margin {\
width: 1px;\
background: #e8e8e8\
}\
.ace-monokai {\
background-color: #FFFFFF;\
color: #000000\
}\
.ace-monokai .ace_cursor {\
color: #000000\
}\
.ace-monokai .ace_marker-layer .ace_selection {\
background: #B5D5FF\
}\
.ace-monokai.ace_multiselect .ace_selection.ace_start {\
box-shadow: 0 0 3px 0px #FFFFFF;\
border-radius: 2px\
}\
.ace-monokai .ace_marker-layer .ace_step {\
background: rgb(198, 219, 174)\
}\
.ace-monokai .ace_marker-layer .ace_bracket {\
margin: -1px 0 0 -1px;\
border: 1px solid #BFBFBF\
}\
.ace-monokai .ace_marker-layer .ace_active-line {\
background: rgba(0, 0, 0, 0.071)\
}\
.ace-monokai .ace_gutter-active-line {\
background-color: rgba(0, 0, 0, 0.071)\
}\
.ace-monokai .ace_marker-layer .ace_selected-word {\
border: 1px solid #B5D5FF\
}\
.ace-monokai .ace_constant.ace_language,\
.ace-monokai .ace_keyword,\
.ace-monokai .ace_meta,\
.ace-monokai .ace_variable.ace_language {\
color: #C800A4\
}\
.ace-monokai .ace_invisible {\
color: #BFBFBF\
}\
.ace-monokai .ace_constant.ace_character,\
.ace-monokai .ace_constant.ace_other {\
color: #275A5E\
}\
.ace-monokai .ace_constant.ace_numeric {\
color: #3A00DC\
}\
.ace-monokai .ace_entity.ace_other.ace_attribute-name,\
.ace-monokai .ace_support.ace_constant,\
.ace-monokai .ace_support.ace_function {\
color: #450084\
}\
.ace-monokai .ace_fold {\
background-color: #C800A4;\
border-color: #000000\
}\
.ace-monokai .ace_entity.ace_name.ace_tag,\
.ace-monokai .ace_support.ace_class,\
.ace-monokai .ace_support.ace_type {\
color: #790EAD\
}\
.ace-monokai .ace_storage {\
color: #C900A4\
}\
.ace-monokai .ace_string {\
color: #DF0002\
}\
.ace-monokai .ace_comment {\
color: #008E00\
}\
.ace-monokai .ace_indent-guide {\
background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==) right repeat-y\
}";

var dom = require("../lib/dom");
dom.importCssString(exports.cssText, exports.cssClass);
});

