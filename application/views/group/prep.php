<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="author" content="Tencent" />
  <title>教师工作室</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
  <link rel="stylesheet" type="text/css" href="/css/gprep.css" />

  <meta property="qc:admins" content="124110632765637457144563757" />
</head>
<body>
	<?php  $this->load->view('public/header.php',$nav); ?>

	<div class="container">
		<div class="main-section">
      <div class="tool-zone fade-in">
        <div class="search-zone">
          <form action="/group/prep?prid=<?=$prid?>&gr=<?=$gr?>&tag=<?=$tag?>&fdid=<?=$fdid?>&ud=<?=$ud?>" method="post" accept-charset="utf-8"  data-def="搜索文件">
            <input type="text" name="key" value="搜索文件" data-def="搜索文件" id="searchKey" />
            <button type="submit"></button>
          </form>
        </div>
      </div>      

      <div class="section-tit">
        <a href="/group/prep" style="float:left">备课检查</a>

        <div style="float:right">
          <select id="prepName">
            <?foreach($plist as $row):?>
              <?if($row['parent']==0):?>
              <option value="<?=$row['id']?>" <?if(isset($row['selected'])):?>selected<?endif?>><?=$row['name']?></option>
              <?endif?>
            <?endforeach?>
          </select>

          <select id="gradeList">
            <option value="0">所有</option>
            <option value="1" <?if($gr==1):?>selected<?endif?>>一年级</option>
            <option value="2" <?if($gr==2):?>selected<?endif?>>二年级</option>
            <option value="3" <?if($gr==3):?>selected<?endif?>>三年级</option>
            <option value="4" <?if($gr==4):?>selected<?endif?>>四年级</option>
            <option value="5" <?if($gr==5):?>selected<?endif?>>五年级</option>
            <option value="6" <?if($gr==6):?>selected<?endif?>>六年级</option>
          </select>  
          
          <select id="typeList">
            <option value="0">所有</option>
            <option value="1" <?if($tag==1):?>selected<?endif?>>语文</option>
            <option value="2" <?if($tag==2):?>selected<?endif?>>数学</option>
            <option value="3" <?if($tag==3):?>selected<?endif?>>英语</option>
            <option value="4" <?if($tag==4):?>selected<?endif?>>体育</option>
            <option value="5" <?if($tag==5):?>selected<?endif?>>音乐</option>
            <option value="6" <?if($tag==6):?>selected<?endif?>>自然</option>
          </select> 

          <?if(count($ulist)>0):?>
          <select id="uList">
            <option value="0">所有</option>
            <?foreach($ulist as $row):?>
            <option value="<?=$row['id']?>"  <?if($row['id']==$ud):?>selected<?endif?>><?=$row['nick']?></option>
            <?endforeach?>
          </select>           
          <?endif?>
        </div>
      </div>

      
        <table width="100%" class="table table-striped table-hover prep-file-list">
            <tr>
              <th>文件名</th>
              <th width="100"><?if(count($flist)>0):?>类型<?endif?></th>
              <th width="100"><?if(count($flist)>0):?>大小<?endif?></th>
            </tr>         
        <?foreach($fold as $row):?>
          <tr>
            <td>
             <a href="/group/prep?prid=<?=$row['prid']?>&ud=<?=$row['uid']?>&fdid=<?=$row['id']?>"><i class="fold"></i><?=$row['name']?></a>
            </td>
            <td></td>
            <td></td>
          </tr>
        <?endforeach?>
        <?if(count($flist)>0):?>
          <?foreach($flist as $row):?>
            <tr>
              <td>
                  <a class="file-name" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>">
                  <?if($row['type'] < 7):?>
                    <i class="icon-type<?=(int) $row['type']?>" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
                  <?else:?>
                    <i class="icon-type" data-fid="<?=$row['fid']?>" data-id="<?=$row['id']?>" ></i>
                  <?endif?>  
                    <?=$row['name']?>
                  </a>  
                  <p id="btn<?=$row['id']?>" class="r-mark"><a href="/download?id=<?=$row['fid']?>">下载</a>  <a class="mark" data-id="<?=$row['id']?>">评论</a> <span><?=$row['mark']?></span></p>  
                  <p id="mark<?=$row['id']?>" class="mark-edit"><input id="input<?=$row['id']?>" type="text"  /> <a data-id="<?=$row['id']?>" class="save">保存</a> <a data-id="<?=$row['id']?>" class="esc">取消</a></p>
              </td>
              <td>
                <?
                  switch($row['type']){
                    case 0:
                      echo '全部类型';
                      break;
                    case 1:
                      echo '图片';
                      break;
                    case 2:
                      echo '文档';
                      break;
                    case 3:
                      echo '音乐';
                      break;
                    case 4:
                      echo '视频';
                      break;
                    case 5:
                      echo '应用';
                      break;
                    case 6:
                      echo '压缩包';
                      break;
                  }
                ?>                
              </td>
              <td><?=$row['size']?></td>
            </tr>
          <?endforeach?>    
      <?elseif($prid!=0):?>
        
          <tr><td colspan="3" align="center">还没有文件哦!</td></tr>
        
        <?endif?>
      </table>
    </div>

      <div class="aside">
        <h3 class="selected">备课检查</h3>
      </div>
  </div>

  <div id="reviewFile" class="modal fade collection reviewWin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">预览文件</h4>
        </div>
        <div class="modal-body">
          <iframe id="reviewIframe" width="750" height="640" border="0" frameborder="0" scroll="false" ></iframe>
        </div>
      </div>
    </div>
  </div>

  <script src="/js/lib/jq.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/gprep.js"></script>
</body>
</html>