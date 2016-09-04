<?php
namespace ElfStack\Forum;

abstract class Privilege extends SplEnum
{
	const __default = self::None;
	const None = 0;
	const All = -1;

	const CreatePost = 1 << 0;
	const ViewPost = 1 << 1;
	const EditPost = 1 << 2;
	const DeletePost = 1 << 3;

	const EditSelfPost = 1 << 4;
	const DeleteSelfPost = 1 << 5;

	const CreateComment = 1 << 6;
	const ViewComment = 1 << 7;
	const EditComment = 1 << 8;
	const DeleteComment = 1 << 9;
	
	const EditSelfComment = 1 << 10;
	const DeleteSelfComment = 1 << 11;
}
