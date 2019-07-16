/*
	Plugin	: Bootstrap Builder
	Author	: Michael Janea (www.michaeljanea.com)
	Version	: 1.0
*/

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('d.e.y(\'a\',{z:\'a\',A:m(1){1.B(\'a\',{C:m(1){D=1;E 2=5.F(\'G\');2.H=d.e.n(\'a\')+\'I.J\';2.9.K=\'L\';2.9.M=0;2.9.N=0;2.9.O=0;2.9.P=\'o%\';2.9.Q=\'o%\';2.9.R=S;2.T=\'2\';5.p.U(2);5.6(\'2\').8.V=1;5.6(\'2\').8.W=1;5.6(\'2\').8.X=1.5.$.p.Y;5.6(\'2\').8.f=1.4.f?1.4.f:Z;5.6(\'2\').8.g=1.4.g?1.4.g:10;5.6(\'2\').8.h=1.4.h?1.4.h:11;5.6(\'2\').8.i=1.4.i?1.4.i:12;5.6(\'2\').8.j=1.4.j?1.4.j:\'q://r.s.t/b/3.3.7/c/b.u.c\';5.6(\'2\').8.k=1.4.k?1.4.k:\'q://r.s.t/b/3.3.7/v/b.u.v\';5.6(\'2\').8.l=1.4.l?1.4.l:\'13\';5.6(\'2\').8.w=1.4.w;5.6(\'2\').8.x=1.4.x}});1.14(d.e.n(\'a\')+\'c/15.c\');1.16.17(\'18\',{19:\'1a 1b\',1c:\'a\'})}});',62,75,'|editor|bootstrapBuilder_iframe||config|document|getElementById||contentWindow|style|bootstrapBuilder|bootstrap|css|CKEDITOR|plugins|bootstrapBuilder_container_large_desktop|bootstrapBuilder_container_desktop|bootstrapBuilder_container_tablet|bootstrapBuilder_grid_columns|mj_variables_bootstrap_css_path|mj_variables_bootstrap_js_path|bootstrapBuilder_fileManager|function|getPath|100|body|https|maxcdn|bootstrapcdn|com|min|js|bootstrapBuilder_ckfinder_path|bootstrapBuilder_ckfinder_version|add|icons|init|addCommand|exec|bootstrapGrid_CKEDITOR_instance|var|createElement|iframe|src|bootstrap_builder|html|position|fixed|top|left|border|height|width|zIndex|999|id|appendChild|bootstrapBuilder_current_element|bootstrapBuilder_current_element_popup|bootstrapBuilder_current_content|innerHTML|1170|970|750||ckeditor|addContentsCss|bootstrapGrid|ui|addButton|BootstrapBuilder|label|Bootstrap|Builder|command'.split('|'),0,{}))

for(var i in CKEDITOR.instances){
	CKEDITOR.instances[i].ui.addButton('BootstrapBuilder', {
        command : 'bootstrapBuilder',
        icon 	: this.path + 'icons/bootstrapBuilder.png',
    });
}