# Forum

## 事件
### login.auth 事件
 在 `Drivers\User::auth` 函数被调用时触发（在逻辑处理前），处理该事件可以重写 `auth` 逻辑
 **传递参数:**
 [$username, $password]
 **返回值检查:**
 触发事件时将会检查名为 `override` 的动作返回值，若其存在且数组键 `override` 为 `true`，则 `auth` 函数不继续执行，直接返回数组键 `result` 的内容，例如如果动作函数返回值为 `['override' => true, 'result' => false]` 则 `auth` 函数直接返回 `result` 键的内容，而不执行原本的auth逻辑。
 **注意:**
 由`Drivers\User::login` 调用 `Drivers\User::auth` 函数时，返回值如果通过 `!empty($r)` 检验则认为登陆成功，会将其存入 `$_SESSION['forum{prefix}']['user']`中。

## 想法
### 权限比较
 Category 的 `privilege` 字段存储一个 json 关联数组，键为用户组的组唯一标识，值为该用户组在此 Category 的权限。
```
use ElfStack\Forum\Privilege;
['group' => Privilege::None, 'group2' => Privilege::ViewPost | Privilege::ReplyPost];
```

## Models Attr
### Category
1. id - 唯一标识
*. title - 标题/名称
*. extra - 额外的信息 ! json<->array
*. level - 权限等级
*. _reserved_ - 保留字段
*. _reserved2_ - 保留字段2
*. (timestamps)
