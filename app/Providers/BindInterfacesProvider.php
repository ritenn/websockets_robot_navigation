<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindInterfacesProvider extends ServiceProvider
{
    /**
     * Dynamically recursively bind interfaces to implementations
     *
     * @return void
     */
    public function register()
    {

        $directoryIterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(__DIR__ . "/../Interfaces", \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($directoryIterator as $item) {

            if($item->isDir()) {

                $interfaces = array_slice(scandir($item->getPathname()), 2);

                if (is_array($interfaces) && !empty($interfaces)) {
                    foreach ($interfaces as $interface) {

                        try {
                            $interfaceType = $item->getFilename();

                            $this->bindInterface($interfaceType, $interface);

                        } catch (\Exception $e)
                        {
                            $msg = "BindInterfacesProvider error: " . $e->getMessage();
                            \Log::error($msg);

                            throw $e;
                        }
                    }

                }
            }
        }

    }

    /**
     * @param string $interfaceType - e.g. Service, Repository
     * @param string $interface - interface file name with extension
     *
     * @throws \Exception
     */
    private function bindInterface(string $interfaceType, string $interface)
    {
        $filename = explode(".php", $interface)[0];
        $filenameBase = explode("Interface", $filename)[0];

        $basePathInterfaces = __DIR__ . "/../Interfaces/" . $interfaceType . '/';
        $basePathImplementation = __DIR__ . "/../" . $interfaceType . '/';

        if
        (
            file_exists($basePathImplementation . $filenameBase . \Str::singular($interfaceType) . '.php') &&
            file_exists($basePathInterfaces . $interface)
        )
        {

            $this->app->bind(
                'App\Interfaces\\' . $interfaceType . '\\' . $filename,
                'App\\' . $interfaceType . '\\' . $filenameBase . \Str::singular($interfaceType)
            );

        } else {

            throw new \Exception("Interface or Implementation file is wrong named or doesn't exists: " . $interface);
        }
    }

}
