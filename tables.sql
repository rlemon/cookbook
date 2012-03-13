--
-- Database: `cookbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients_list`
--

CREATE TABLE IF NOT EXISTS `ingredients_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `ingredient` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) NOT NULL,
  `author_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `prep_directions` text NOT NULL,
  `cook_directions` text NOT NULL,
  `post_directions` text NOT NULL,
  `prep_time_hours` float NOT NULL,
  `prep_time_minutes` float NOT NULL,
  `cook_time_hours` float NOT NULL,
  `cook_time_minutes` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_mappings`
--

CREATE TABLE IF NOT EXISTS `tag_mappings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) NOT NULL,
  `recipe_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_openids`
--

CREATE TABLE IF NOT EXISTS `user_openids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `creation_date` varchar(255) NOT NULL,
  `last_active` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
