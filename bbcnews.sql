-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2026 at 09:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbcnews`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) DEFAULT NULL,
  `prezime` varchar(32) DEFAULT NULL,
  `korisnicko_ime` varchar(32) DEFAULT NULL,
  `lozinka` varchar(255) DEFAULT NULL,
  `razina` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'admin', '123', 'admin123', '$2y$10$CfnisyYnuOc4RScMhkoTfOelIXCM3eiaopCTckchqzG1bcA91r8Hm', 1),
(2, 'korisnik', '123', 'korisnik123', '$2y$10$S9olQPUmDSykdqSUC2z4e.yGd28QsMVlqTiVrWgveHMQ8bjMoD3zO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(255) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(2, '07.06.2026.', 'Biscuit heiress apologies for Nazi comments', 'Verena Bahlsen faced a backlash after defending her firm\'s use of forced labour during Nazi rule.', 'Verena Bahlsen, the 25-year-old heiress to the Bahlsen biscuit empire, has apologised after defending her family\'s use of forced labour during the Nazi era. She sparked controversy when she said the company had used forced labourers during World War Two and that they had been treated well and equally to German workers. Her comments drew immediate backlash from historians and politicians. The Central Council of Jews in Germany said her remarks were cynical and showed a lack of sensitivity. Bahlsen later issued an apology saying she regretted her choice of words and that she takes the issue very seriously. The Bahlsen company, founded in 1889 in Hanover, is best known for its Leibniz butter biscuits. During World War Two, the company used around 200 forced labourers, mostly Ukrainian women. Historians were quick to point out that forced labourers were treated very differently from German workers, often subjected to harsh conditions and discrimination. The controversy has sparked a wider debate in Germany about corporate responsibility for actions taken during the Nazi period.', 'leibniz.jpg', 'news', 0),
(3, '07.06.2026.', 'US snubs effort to tackle online extremism', 'The scheme aims to tackle terror content after the Christchurch attacks, but the US opts out.', 'The United States has declined to join a global effort to tackle online extremism following the Christchurch mosque attacks in New Zealand. The Christchurch Call is a pledge by governments and technology companies to eliminate terrorist and violent extremist content online. It was launched by New Zealand Prime Minister Jacinda Ardern and French President Emmanuel Macron. More than 40 countries signed the pledge, but the US said it could not join due to concerns about freedom of speech protections under the First Amendment. A White House statement said the US is committed to working with other nations to counter terrorist content online, but it cannot endorse the specific document. The Christchurch attacks in March 2019 killed 51 people at two mosques. The attacker livestreamed the attack on Facebook, prompting widespread criticism of social media companies. Technology firms including Facebook, Google, Twitter and Microsoft have signed up to the Christchurch Call. They have committed to preventing the upload of terrorist content and ensuring faster removal of such material when it does appear.', 'online.jpg', 'news', 0),
(4, '07.06.2026.', 'Window cleaners rescued from swinging lift', 'The workers in Oklahoma City were trapped about 50-storeys up as the lift began to swing out of control.', 'Two window cleaners were rescued after their suspended platform began swinging uncontrollably near the top of a skyscraper in Oklahoma City. The workers were trapped about 50 storeys up on the side of the Leadership Square building when their lift started to malfunction. Emergency services were called to the scene and firefighters worked for several hours to bring the men to safety. Both workers were reported to be shaken but uninjured after their terrifying ordeal. Witnesses on the street below filmed the platform swinging back and forth against the side of the building. The incident caused significant disruption in the downtown area as emergency crews blocked off surrounding streets. Oklahoma City Fire Department said the rescue was complex due to the height involved and the unpredictable movement of the platform. The cause of the malfunction is being investigated by safety authorities. Building management issued a statement saying they were relieved the workers were safe and that a full review of all maintenance equipment would be carried out immediately. Window cleaning at height is considered one of the more dangerous occupations, with workers relying heavily on the integrity of their suspension equipment.', 'window.jpg', 'news', 0),
(5, '07.06.2026.', 'Alonso unhurt after Indy practice crash', 'Two-time Formula 1 world champion Fernando Alonso escapes unhurt after crashing into a wall during practice for the Indianapolis 500.', 'Ex-Formula 1 world champion Fernando Alonso emerged unhurt after crashing heavily into the wall during practice for the Indianapolis 500. The 37-year-old Spaniard was making his second attempt at the famous race as part of his bid to complete motorsport\'s unofficial triple crown, having already won the Monaco Grand Prix and the Le Mans 24 Hours. Alonso said he made a mistake on the entry to Turn Three, losing the front aerodynamic downforce and sliding into the barrier at high speed. The accident was the latest setback in a troubled preparation for the race, with the McLaren team having suffered electronic and mechanical problems throughout practice week. Alonso was taken to the medical centre at the Indianapolis Motor Speedway but was released after checks, confirming he had suffered no injuries. He apologised to his team and expressed hope that they could repair the car in time for further practice sessions later in the week. The Indianapolis 500 is held annually on the Sunday of Memorial Day weekend and is one of the most prestigious motorsport events in the world. Qualifying for the race takes place over two weekends, with the fastest nine drivers on the final day competing for pole position.', 'alonso.jpg', 'sport', 0),
(6, '07.06.2026.', 'Sharapova pulls out of French Open', 'Two-time French Open winner Maria Sharapova will miss this year\'s event because of a shoulder injury.', 'Maria Sharapova has withdrawn from the French Open due to a shoulder injury, missing out on a chance to win a third Roland Garros title. The Russian tennis star, who won the clay court Grand Slam in 2012 and 2014, said the injury had been troubling her for several weeks and that she had been unable to recover in time for the tournament. Sharapova, who returned to professional tennis in 2017 after serving a 15-month doping ban, has struggled with various injuries throughout her career. The withdrawal is a significant blow for the five-time Grand Slam champion, who had been looking to build on some encouraging form on clay in the lead-up to Roland Garros. Tournament organisers expressed disappointment at the news, noting that Sharapova is always a fan favourite at the Paris event. The French Open, held annually at the Roland Garros stadium in Paris, is the premier clay court tennis tournament in the world. Sharapova said she hoped to be fit in time for the grass court season, which begins in June and culminates with Wimbledon. She thanked her fans for their support and promised to return to competition as soon as her shoulder had fully healed.', 'sharapova.jpg', 'sport', 0),
(8, '07.06.2026.', 'The top six summer transfer targets', 'BBC Sport\'s David Ornstein looks at the top summer transfer targets for the Premier League\'s top six clubs.', 'With the summer transfer window approaching, BBC Sport takes a look at the most coveted players being targeted by the Premier League\'s top six clubs. Manchester City are reportedly interested in strengthening their attacking options following another dominant title winning campaign. Liverpool, fresh from their Champions League triumph, are expected to be relatively quiet in the market but may look to add depth in certain positions. Chelsea are preparing for a busy summer with several key players linked with moves away from Stamford Bridge. Arsenal are expected to invest significantly as they look to close the gap on the top four after a disappointing season. Manchester United continue their search for consistency with major investment planned in midfield and attack. Tottenham Hotspur, fresh from their first Champions League final appearance, are looking to build on that achievement with targeted signings. Among the most discussed transfer targets are several young European midfielders and a number of proven Premier League forwards. Transfer fees are expected to reach record levels once again this summer, with the financial power of English clubs drawing players from across Europe and beyond. The window officially opens on July 1st and clubs are permitted to conduct pre-agreement deals in the weeks beforehand.', 'summer.jpg', 'sport', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
