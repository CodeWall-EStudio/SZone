define(function(){
/*
个人文件列表 /file/index
个人文件夹列表 /folder/index
搜索个人文件 /file/search
收藏文件 /file/collect
共享文件 /file/share
查找用户 /user/search
查找小组 /group/search
收件箱 /message/inbox
发件箱 /message/outbox
我的共享 /user/share
我的收藏 /user/collection
我的回收 /user/recycle
备注文件 /file/memo
文件重命名 /file/rename
文件夹重命名 /folder/rename
新建文件夹 /folder/add
复制文件到文件夹 /file/copy
删除文件 /file/del
删除文件夹 /folder/del

部门文件列表 /file/index
部门文件夹列表 /folder/index
搜索部门文件 /file/search
拉小组信息 /group/index
修改小组信息 /group/modify
发留言 /comment/add
留言列表 /comment/index
收藏文件 /file/collect
共享文件 /file/share
查找用户 /user/search
查找小组 /group/search
新建文件夹 /folder/add
删除文件 /file/del
删除文件夹 /folder/del
文件重命名 /file/rename
文件夹重命名 /folder/rename

学校文件列表 /file/index
审核文件 /file/audit
审核文件历史 /file/history
*/	
	var config = {
		'filelist' : '/file/index',
		'foldlist' : '/folder/index',
		'search' : '/file/search',
		'coll' : '/file/collect',
		'uncoll' : '/file/uncollect',
		'share' : '/file/share',
		'usersearch' : '/user/search',
		'groupsearch' : '/group/search',
		'msgin' : '/message/inbox',
		'msgout' : '/message/outbox',
		'myshare' : '/user/share',
		'mycoll' : '/usercollection',
		'recy' : '/user/recycle',
		'memo' : '/file/memo',
		'rename' : '/file/rename',
		'frename' : '/folder/rename',
		'newfold' : '/folder/add',
		'copy' : '/file/copy',
		'delfile' : '/file/del',
		'delfold' : '/file/delfold',
		'audit' : '/file/audit',
		'history' : '/file/history'
	}

	return config;
})