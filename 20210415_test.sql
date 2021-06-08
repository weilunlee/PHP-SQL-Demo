--
-- 資料庫： `20210415_test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `id` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `chi` int(11) DEFAULT NULL,
  `eng` int(11) DEFAULT NULL,
  `mat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `student`
--

INSERT INTO `student` (`id`, `name`, `chi`, `eng`, `mat`) VALUES
('s1001', 'OHO', 99, 88, 77),
('s10010', 'OvO', 66, 77, 99),
('s1002', 'OAO', 20, 20, 50),
('s1003', 'OBO', 60, 60, 60),
('s1004', 'O.O', 60, 60, 99),
('s1005', 'OKO', 50, 80, 77),
('s1006', 'OAAAO', 1, 2, 3),
('s1007', 'OqO', 60, 80, 70),
('s1008', 'OqO', 60, 80, 70),
('s1009', 'OnO', 123, 20, 30);

-- --------------------------------------------------------
