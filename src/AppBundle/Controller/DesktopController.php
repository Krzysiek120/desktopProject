<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use abhimanyu\systemInfo\SystemInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        $system = SystemInfo::getInfo();
        $systemMemInfo = $this->getSystemMemInfo();
        $uptime = $this->getUptime();

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
            'getUptime' => $uptime,

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
        $days = explode(".",(($uptime % 31556926) / 86400));
        $hours = explode(".",((($uptime % 31556926) % 86400) / 3600));
        $minutes = explode(".",(((($uptime % 31556926) % 86400) % 3600) / 60));
        $seconds = explode(".",((((($uptime % 31556926) % 86400) % 3600) / 60) / 60));

        $time = $days[0].":".$hours[0].":".$minutes[0].":".$seconds[0];

        return $time;

    }
}
