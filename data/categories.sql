CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isPinned` tinyint(4) DEFAULT '0',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orderId` int(11) DEFAULT NULL,
  `isPublic` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
