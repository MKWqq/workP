/**
 * Created by Administrator on 2017/7/27.
 */
import languageObject from '@/components/vueditor/language/lang.cn'
import emoji from '@/components/vueditor/plugins/emoji.min'

let uploadUrl = '';
/*let plugins = [
  {
    name: 'emoji',
    element: {
      type: 'button',
      lang: {
        title: 'Emoji'
      },
      className: 'icon-smile-o'
    },
    // emoji loaded from script tag, line 35
    component: emoji
  }
];*/
var config={
   toolbar: [
     'undo','redo', '|','bold', 'italic','underline','|','superscript','subscript', '|',
     'fontName', 'fontSize', 'foreColor','backColor','|','justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull','|',
     'insertOrderedList', 'insertUnorderedList','|','link','unLink','|','emoji', /*'picture',*/'removeFormat'
   ],
  lang:languageObject,
  fontSize: ['12px', '14px', '16px', '18px', '0.8rem', '1.0rem', '1.2rem', '1.5rem', '2.0rem'],
  fontName: [
    {val: '微软雅黑'},
    {val: 'times new roman'},
    {val: 'Courier New'}
  ],
  uploadUrl: uploadUrl,
  // plugins: plugins
}
export  default config


