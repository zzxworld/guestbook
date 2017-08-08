-- MySQL dump 10.16  Distrib 10.1.20-MariaDB, for osx10.12 (x86_64)
--
-- Host: guestbook    Database: guestbook
-- ------------------------------------------------------
-- Server version	10.1.20-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL,
  `ip` int(11) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `email` (`email`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'zzxworld@163.com',2130706433,'','一个年轻的程序员和一个项目经理登上了一列在山里行驶的火车，他们发现列车上几乎都坐满了，只有两个在一起的空位，这个空位的对面是一个老奶奶和一个年轻漂亮的姑娘。两个上前坐了下来。程序员和那个姑娘他们比较暧昧地相互看对方。这时，火车进入山洞，车厢里一片漆黑。此时，只听见一个亲嘴的声音，随后就听到一个响亮的巴掌声。很快火车出了山洞，他们四个人都不说话。\r\n\r\n那个老奶奶在喃喃道，&ldquo;这个年轻小伙怎么这么无礼，不过我很高兴我的孙女扇了一个巴掌&rdquo;。\r\n\r\n项目经理在想，&ldquo;没想到这个程序员居然这么大胆，敢去亲那姑娘，只可惜那姑娘打错了人，居然给打了我。&rdquo;\r\n\r\n漂亮的姑娘想，&ldquo;他亲了我真好，希望我的祖母没有打疼他&rdquo;。\r\n\r\n程序员坐在那里露出了笑容，&ldquo;生活真好啊。这一辈子能有几次机会可以在亲一个美女的同时打项目经理一巴掌啊&rdquo;','2017-08-08 15:28:10',NULL),(2,'zzxworld@163.com',2130706433,'','有一个驾驶热气球的人发现他迷路了。他降低了飞行的高度，并认出了地面上的一个人。他继续下降高度并对着那个人大叫，&ldquo;打扰一下，你能告诉我我在哪吗？&rdquo;\r\n\r\n下面那个人说：&ldquo;是的。你在热气球里啊，盘旋在30英尺的空中&rdquo;。\r\n\r\n热气球上的人说：&ldquo;你一定是在IT部门做技术工作&rdquo;。\r\n\r\n&ldquo;没错&rdquo;，地面上的人说到，&ldquo;你是怎么知道的？&rdquo;\r\n\r\n&ldquo;呵呵&rdquo;，热气球上的人说，&ldquo;你告诉我的每件事在技术上都是对的，但对都没有用&rdquo;。\r\n\r\n地面上的人说，&ldquo;你一定是管理层的人&rdquo;。\r\n\r\n&ldquo;没错&rdquo;，热气球上的人说，&ldquo;可是你是怎么知道的？&rdquo;\r\n\r\n&ldquo;呵呵&rdquo;，地面上的那人说到，&ldquo;你不知道你在哪里，你也不知道你要去哪，你总希望我能帮你。你现在和我们刚见面时还在原来那个地方，但现在却是我错了&rdquo;。','2017-08-08 15:29:10',NULL),(3,'zzxworld@163.com',2130706433,'','有一个小伙子在一个办公大楼的门口抽着烟，一个妇女路过他身边，并对他说，&ldquo;你知道不知道这个东西会危害你的健康？我是说，你有没有注意到香烟盒上的那个警告（Warning）？&rdquo;\r\n\r\n小伙子说，&ldquo;没事儿，我是一个程序员&rdquo;。\r\n\r\n那妇女说，&ldquo;这又怎样？&rdquo;\r\n\r\n程序员说，&ldquo;我们从来不关心Warning，只关心Error&rdquo;','2017-08-08 15:29:20',NULL),(4,'zzxworld@163.com',2130706433,'','有一天一个程序员见到了上帝.\r\n\r\n上帝: 小伙子,我可以满足你一个愿望.\r\n\r\n程序员: 我希望中国国家队能再次打进世界杯.\r\n\r\n上帝: 这个啊!这个不好办啊,你还说下一个吧!\r\n\r\n程序员: 那好!我的下一个愿望是每天都能休息6个小时以上.\r\n\r\n上帝: 还是让中国国家打进世界杯.','2017-08-08 15:29:33',NULL),(5,'zzxworld@163.com',2130706433,'','当世界末日还有5分钟就要到来的时候\r\n\r\n程序员: 让我们在这最后的时刻作些什么吧!\r\n\r\n女友: 那好,让我们在做最后一次吧!\r\n\r\n程序员: 那剩下的4分50秒做什么啊?','2017-08-08 15:29:41',NULL),(6,'zzxworld@163.com',2130706433,'','项目经理: 如果我再给你一个人,那可以什么时候可以完工?\r\n\r\n程序员: 3个月吧!\r\n\r\n项目经理: 那给两个呢?\r\n\r\n程序员: 1个月吧!\r\n\r\n项目经理: 那100呢?\r\n\r\n程序员: 1年吧!\r\n\r\n项目经理: 那10000呢?\r\n\r\n程序员: 那我将永远无法完成任务.','2017-08-08 15:29:58',NULL),(7,'zzxworld@163.com',2130706433,'','Q：你是怎么区分一个内向的程序员和一个外向的程序员的？\r\n\r\nA：外向的程序员会看着你的鞋和你说话时。\r\n\r\nQ：为什么程序员不能区分万圣节和圣诞节？\r\n\r\nA：这是因为Oct 31 == Dec 25！（八进制的31==十进制的25）','2017-08-08 15:30:24',NULL),(8,'zzxworld@163.com',2130706433,'','如果C++是一把锤子的话，那么编程就会变成大手指头。\r\n\r\n如果你找了一百万只猴子来敲打一百万个键盘，那么会有一只猴子会敲出一段Java程序，而其余的只会敲出Perl程序。\r\n\r\n一阵急促的敲门声，&ldquo;谁啊！&rdquo;，过了5分钟，门外传来&ldquo;Java&rdquo;。\r\n\r\n如果说Java很不错是因为它可以运行在所有的操作系统上，那么就可以说肛交很不错，因为其可以使用于所有的性别上。','2017-08-08 15:30:37',NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-08 23:32:34
