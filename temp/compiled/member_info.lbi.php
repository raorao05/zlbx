<?php if ($this->_var['user_info']): ?>
    您好，<a href="user.php" title="用户中心"><?php echo $this->_var['user_info']['username']; ?></a>，欢迎您回来！
<?php else: ?>
    请<em><a href="user.php" title="登录">登录</a>|<a href="user.php?act=register" title="注册">注册</a></em>
<?php endif; ?>