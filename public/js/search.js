getTags((function(){var t,e,a,s=document.querySelector("input[name=tags-select-mode]"),o=new Tagify(s,{mode:"select",whitelist:tagsWhiteList,blacklist:["foo","bar"],keepInvalidTags:!0});function c(t){$.ajax({url:"/file/filter",data:t,success:function(t){$("#table-content").html(t.table)}})}o.on("input",(function(e){var a=e.detail.value;c({search:t=a})})),o.on("add",(function(e){var s=e.detail.data.value;c({search:t=s,sort_type:a})})),$("body").on("click",".table-header",(function(){var s=$(this).data("id"),o=$(this).data("sort_type"),n="";"asc"==o&&($(this).data("sort_type","desc"),n="desc"),"desc"==o&&($(this).data("sort_type","asc"),n="asc"),e=s,a=n,console.log(e),console.log(a),c({search:t,sort_column:e,sort_type:a})}))}));