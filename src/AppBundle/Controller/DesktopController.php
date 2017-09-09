<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use abhimanyu\systemInfo\SystemInfo;
use AppBundle\Entity\Stat;

class DesktopController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/ajax", name="ajax")
     */
    public function ajaxAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $system = SystemInfo::getInfo();
        $systemMemInfo = $this->getSystemMemInfo();

        $stat = new Stat();
        $stat->setCpuFreq($system::getCpuFreq())
            ->setFreeDiskSpace($this->getFreeDiskSpace())
            ->setFreeMemory($systemMemInfo['MemFree'])
            ->setHostname($system::getHostname())
            ->setUpTime($this->getUptime());

        $entityManager->persist($stat);
        $entityManager->flush();

        return new JsonResponse([
            'getHostname' => $system::getHostname(),
            'getCpuArchitecture' => $system::getCpuArchitecture(),
            'getKernelVersion' => $system::getKernelVersion(),
            'getCpuModel' => $system::getCpuModel(),
            'getCpuVendor' => $system::getCpuVendor(),
            'getCpuFreq' => $system::getCpuFreq(),
            'getLoad' => $system::getLoad(),
            'getUpTime' => $system::getUpTime(),
            'getOS' => $system::getOS(),
            'getMemoryUsage' => memory_get_usage(),
            'getMemoryTotal' => $systemMemInfo['MemTotal'],
            'getFreeMemory' => $systemMemInfo['MemFree'],
            'getUptime' => $this->getUptime(),
            'getFreeDiskSpace' => $this->getFreeDiskSpace(),
            'getTotalDiskSpace' => $this->getTotalDiskSpace(),
            'getIpAddress' => $this->getIpAddress(),
        ]);
    }

    private function getSystemMemInfo()
    {
        $meminfo = @file_get_contents("/proc/meminfo");
        if ($meminfo) {
            $data = explode("\n", $meminfo);
            $meminfo = [];
            foreach ($data as $line) {
                if( strpos( $line, ':' ) !== false ) {
                    list($key, $val) = explode(":", $line);
                    $val = trim($val);
                    $val = preg_replace('/ kB$/', '', $val);
                    if (is_numeric($val)) {
                        $val = intval($val);
                    }
                    $meminfo[$key] = $val;
                }
            }
            return $meminfo;
        }
        return  null;
    }

    private function getUptime() {

        $uptime = @file_get_contents( "/proc/uptime");

        $uptime = explode(" ",$uptime);
        $uptime = $uptime[0];
        $hours = explode(".",((($uptime % 31556926) % 86400) / 3600));
        $minutes = explode(".",(((($uptime % 31556926) % 86400) % 3600) / 60));
        $seconds = explode(".",((((($uptime % 31556926) % 86400) % 3600) / 60) / 60));

        $time = 'hours: '.$hours[0].' minutes: '.$minutes[0];

        return $time;

    }

    private function getFreeDiskSpace() {

        $freeDiskSpace = disk_free_space("/");

        return round($freeDiskSpace/1024) . 'KB';

    }

    private function getTotalDiskSpace() {

        $totalDiskSpace = disk_total_space("/");

        return round($totalDiskSpace/1024) . 'KB';

    }

    private function getIpAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

}
