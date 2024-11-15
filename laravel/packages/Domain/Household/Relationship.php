<?php

namespace Packages\Domain\Household;

/**
 * 世帯主との続柄
 */
enum Relationship: int
{
    case SELF = 1; // 本人
    case SPOUSE = 2; // 配偶者
    case CHILD = 3; // 子
    case FATHER = 4; // 父
    case MOTHER = 5; // 母
    case BROTHER = 6; // 兄
    case YOUNGER_BROTHER = 7; // 弟
    case SISTER = 8; // 姉
    case YOUNGER_SISTER = 9; // 妹
    case FATHER_IN_LAW = 10; // 義父
    case MOTHER_IN_LAW = 11; // 義母
    case BROTHER_IN_LAW = 12; // 義兄
    case SISTER_IN_LAW = 13; // 義姉
    case SON = 14; // 孫
    case GRANDSON = 15; // ひ孫
    case GREAT_GRANDSON = 16; // おじ
    case UNCLE = 17; // おば
    case AUNT = 18; // いとこ
    case COUSIN = 19; // 祖父
    case GRANDFATHER = 20; // 祖母
    case GRANDMOTHER = 21; // 曽祖父
    case GREAT_GRANDFATHER = 22; // 曽祖母
    case GREAT_GRANDMOTHER = 23; // 姪
    case NIECE = 24; // 甥
    case NEPHEW = 25; // その他
    case OTHER = 26; // その他
}
