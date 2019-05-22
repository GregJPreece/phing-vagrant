<?php

namespace GregJPreece\Phing\Vagrant\Run;

use MyCLabs\Enum\Enum;

/**
 * Types of message that may be logged by Vagrant
 * @author Greg J Preece <greg@preece.ca>
 * @see https://www.vagrantup.com/docs/cli/machine-readable.html
 * @TODO Update Vagrant docs - some values here were undocumented
 */
class VagrantLogType extends Enum {

    const ACTION = 'action';
    
    /**
     * Name of a box installed into Vagrant. 
     */
    const BOX_NAME = 'box-name';
    
    /**
     * Provider for an installed box. 
     */
    const BOX_PROVIDER = 'box-provider';
    
    /**
     * A sub-command of Vagrant that is available. 
     */
    const CLI_COMMAND = 'cli-command';
    
    /**
     * An error occurred that caused Vagrant to exit. This contains that error. 
     * Contains two data elements: type of error, error message.  
     */
    const ERROR_EXIT = 'error-exit';
    
    /**
     * Metadata about the Vagrant box being controlled or its provider
     */
    const METADATA = 'metadata';
    
    /**
     * The name of a plugin installed in Vagrant
     */
    const PLUGIN_NAME = 'plugin-name';
    
    /**
     * The version of a plugin installed in Vagrant
     * (The name of the plugin will appear in the target field)
     */
    const PLUGIN_VERSION = 'plugin-version';
    
    /**
     * The provider name of the target machine.
     */
    const PROVIDER_NAME = 'provider-name';
    
    /**
     * The OpenSSH compatible SSH config for a machine. This is usually the 
     * result of the "ssh-config" command.
     */
    const SSH_CONFIG = 'ssh-config';
    
    /**
     * The state ID of the target machine. 
     */
    const STATE = 'state';
    
    /**
     * Human-readable description of the state of the machine. This is the 
     * long version, and may be a paragraph or longer.
     */
    const STATE_HUMAN_LONG = 'state-human-long';
    
    /**
     * Human-readable description of the state of the machine. This is the 
     * short version, limited to at most a sentence. 
     */
    const STATE_HUMAN_SHORT = 'state-human-short';
    
    /**
     * Not 100% what these represent, will seek clarification
     */
    const UI = 'ui';
    
    /**
     * If the log type does not match any of the known type s, create
     * an enum with this type
     */
    const UNKNOWN = 'unknown';
    
    /**
     * Special-case log type used when querying Vagrant versions.
     * No idea why this isn't of a more generic log type.
     */
    const VERSION_INSTALLED = 'version-installed';
    
    /**
     * Special-case log type used when querying Vagrant versions.
     * No idea why this isn't of a more generic log type.
     */
    const VERSION_LATEST = 'version-latest';
    
}
