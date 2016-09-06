<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;
use ElfStack\Forum\Core\RequiredAttrInterface;
use ElfStack\Forum\Core\Helper;

class User extends Model implements InstallerInterface, RequiredAttrInterface
{
	protected $table = 'user';

	public static $encrypter = false;

	public static $saltLength = 15;

	const requiredAttr = ['username', 'nick', 'password', 'email'];

	protected $fillable = self::requiredAttr;

	protected $hidden = ['password'];

	protected $casts = [
		'privilege' => 'array'
	];

	public function encryptPassword()
	{
		if (!is_callable(self::$encrypter)) {
			self::$encrypter = function ($str) {
				$salt = Helper::random(self::$saltLength, 'abcdefghijklmnopqrstuvwxyz0123456789');
				return $salt.crypt($str, $salt);
			};
		}

		if (!isset($this->password)) {
			throw new Exception('Attribute `password` not set, could not encrypt password.');
		}
		$encrypter = self::$encrypter;
		$this->password = $encrypter($this->password);
		return $this->password;
	}

	public function auth($password)
	{
		$encrypter = self::$encrypter;
		return hash_equals($this->password, $encrypter($password));
	}

	public function posts()
	{
		return $this->hasMany(__NAMESPACE__.'\Post', 'authorId');
	}

	public function group()
	{
		return $this->belongsTo(__NAMESPACE__.'Group', 'groupId');
	}

	public function validateAttr()
	{
		foreach (self::requiredAttr as $key) {
			if (!isset($this->{$key})) {
				return "Key `$key` is required when creating a `User`.";
			}
		}
		return true;
	}

	static public function setUpDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('user');
		$builder->create('user', function ($table) {
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('nick')->unique();
			$table->string('password');
			$table->string('email')->unique();
			$table->text('group')->nullable();
			$table->text('_reserved_')->nullable();
			$table->text('_reserved2_')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}
}
