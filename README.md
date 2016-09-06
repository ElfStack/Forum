# Forum
 `public` 目录下的所有文件均为测试代码  
 测试方法:  
 把WEB目录指向public文件夹  
 访问 `domain/install` 执行数据库安装工作  
 <font color=red>**注意！数据库安装时如果目标表已经存在则会删除原本表的所有数据，所以请务必检查 `public/include/config.php` 内的数据库配置**</font>

## 事件
### login.auth 事件
 在 `Drivers\User::auth` 函数被调用时触发（在逻辑处理前），处理该事件可以重写 `auth` 逻辑  
 **传递参数:**  
 [$username, $password]  
 **返回值检查:**  
 触发事件时将会检查名为 `override` 的动作返回值，若其存在且数组键 `override` 为 `true`，则 `auth` 函数不继续执行，直接返回数组键 `result` 的内容，例如如果动作函数返回值为 `['override' => true, 'result' => false]` 则 `auth` 函数直接返回 `result`   键的内容，而不执行原本的auth逻辑。  

 **注意:**  
 由`Drivers\User::login` 调用 `Drivers\User::auth` 函数时，返回值如果通过 `!empty($r)` 检验则认为登陆成功，会将其存入 `$_SESSION['forum{prefix}']['user']`中。

## 想法
### 权限比较
 Category 的 `privilege` 字段存储一个 json 关联数组，键为用户组的组唯一标识，值为该用户组在此 Category 的权限。  
```php
use ElfStack\Forum\Privilege;
['group' => Privilege::None, 'group2' => Privilege::ViewPost | Privilege::ReplyPost];
```

## Models Attr
### Category
1. id - 唯一标识
2. title - 标题/名称
3. extra - 额外的信息 ! json<->array 自动转换
	1. 其中有一个键 `description` 为该 Category 的描述
4. level - 权限等级
5. _reserved_ - 保留字段
6. _reserved2_ - 保留字段2
7. (timestamps)

### Comment
1. id - 唯一标识符
2. title - 评论的标题(可以为空[考虑到某些情况下使用不到])
3. content - 评论的内容
4. authorId - 与之关联的作者 ID
5. postId - 与之关联的帖子 ID
6. _reserved_
7. _reserved2_
8. (timestamps)

### Group
1. id - 唯一标识符
2. name - 组的名称
3. extra - 暂时未用到的额外信息 ! json<->array 自动转换
4. _reserved_
5. (timestamps)

### Post
1. id - 唯一标识符
2. title - 帖子标题
3. content - 帖子内容
4. summary - 帖子的概述
5. authorId - 与之联系的作者ID
6. categoryId - 与之联系的 Category ID
7. privilege - 用于覆盖 Category 下的权限
8. _reserved_
9. _reserved2_
10. (timestamps)
