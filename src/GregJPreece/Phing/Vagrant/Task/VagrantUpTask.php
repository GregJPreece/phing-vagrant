<?php

namespace GregJPreece\Phing\Vagrant\Task;

/**
 * Wrapper for Vagrant's "up" command
 * @author Greg J Preece <greg@preece.ca>
 */
class VagrantUpTask extends VagrantTask {

    /**
     * Vagrant ID of the machine to start
     * @var string
     */
    private $machineId;
    
    /**
     * Name of the Vagrant machine to start
     * @var string
     */
    private $machineName;
    
    /**
     * Whether to destroy a new machine if a fatal error
     * occurs during provisioning. (Only applies to first "up")
     * @var bool
     */
    private $destroyOnError = true;
    
    /**
     * Whether to install the machine's provisioner if it is
     * not already present
     * @var bool
     */
    private $installProvider = true;
    
    /**
     * Name of the provider to use when starting the machine,
     * overrides the provider specified in Vagrantfile.
     * @var string
     */
    private $provider = 'virtualbox';
    
    /**
     * Forces or prevents the running of provisioners on start
     * @var boolean
     */
    private $provision;
    
    /**
     * Called by Phing to run the task
     * @return void
     */
    public function main(): void {
        $machine = '';
        $flags = [];
        
        // ID trumps name
        if ($this->getMachineId() != '') {
            $machine = $this->getMachineId();
        } else if ($this->getMachineName() != '') {
            $machine = $this->getMachineName();
        }
        
        if ($this->getDestroyOnError() !== null) {
            $flags[] = ($this->getDestroyOnError()) 
                     ? '--destroy-on-error'
                     : '--no-destroy-on-error';
        }
        
        if ($this->getInstallProvider() !== null) {
            $flags[] = ($this->getInstallProvider())
                     ? '--install-provider'
                     : '--no-install-provider';
        }
        
        if ($this->getProvision() !== null) {
            $flags[] = ($this->getProvision())
                     ? '--provision'
                     : '--no-provision';
        }
        
        if ($this->getProvider() != '') {
            $flags[] = '--provider ' . $this->getProvider();
        }
        
        $command = 'up ' . $machine . ' ' . implode(' ', $flags);
        echo($command);
        $this->runCommand($command);
    }
    
    /**
     * Returns the Vagrant ID of the machine to start
     * @return string|null
     */
    public function getMachineId(): ?string {
        return $this->machineId;
    }

    /**
     * Returns the name of the Vagrant machine to start
     * @return string|null
     */
    public function getMachineName(): ?string {
        return $this->machineName;
    }

    /**
     * Returns whether to destroy a machine if fatal
     * provisioning errors are encountered
     * @return bool|null
     */
    public function getDestroyOnError(): ?bool {
        return $this->destroyOnError;
    }

    /**
     * Returns whether to install the machine provider
     * if it is not already available
     * @return string|null
     */
    public function getInstallProvider(): ?bool {
        return $this->installProvider;
    }

    /**
     * Returns the provider to use when booting the machine(s)
     * @return string|null
     */
    public function getProvider(): ?string {
        return $this->provider;
    }

    /**
     * Returns whether or not to run provisioners
     * @return bool|null
     */
    public function getProvision(): ?bool {
        return $this->provision;
    }

    /**
     * Sets the Vagrant ID of the machine to start
     * @param string $machineId Vagrant machine ID
     * @return void
     */
    public function setMachineId(string $machineId): void {
        $this->machineId = $machineId;
    }
    
    /**
     * Sets the name of the Vagrant machine to start
     * @param string $machineName Vagrant machine name
     * @return void
     */
    public function setMachineName(string $machineName): void {
        $this->machineName = $machineName;
    }

    /**
     * Sets whether to destroy VMs on fatal error during their statuses.
     * @param bool $destroyOnError Whether to destroy VMs on error
     * @return void
     */
    public function setDestroyOnError(bool $destroyOnError): void {
        $this->destroyOnError = $destroyOnError;
    }

    /**
     * Sets whether to install the machine's provider
     * if it is not already available
     * @param bool $installProvider
     * @return void
     */
    public function setInstallProvider(bool $installProvider): void {
        $this->installProvider = $installProvider;
    }

    /**
     * Sets the provider that should be used when starting the machine(s)
     * @param string $provider Provider name
     * @return void
     */
    public function setProvider(string $provider): void {
        $this->provider = $provider;
    }

    /**
     * If true, provisioners are forced to run. If false, they are forced to
     * not run. By default, it does neither.
     * @param bool $provision Whether to run provisioners
     * @return void
     */
    public function setProvision(bool $provision): void {
        $this->provision = $provision;
    }
    
}
