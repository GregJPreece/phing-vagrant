<?php

namespace GregJPreece\Phing\Vagrant\Task;

use GregJPreece\Phing\Vagrant\Run\VagrantOutputParser;
use GregJPreece\Phing\Vagrant\Run\VagrantLogEntry;
use GregJPreece\Phing\Vagrant\Run\VagrantLogType;
use BuildException;

/**
 * Base task class from which other tasks derive
 * @author Greg J Preece <greg@preece.ca>
 */
abstract class VagrantTask extends \Task {

    /**
     * Whether to output full logging or filtered logging
     * @var bool
     */
    protected $verbose = false;
    
    /**
     * Whether to run silently (no output) - overrides verbosity
     * @var bool
     */
    protected $silent = false;
    
    /**
     * Passes a command through to Vagrant and parses the response
     * @param string $command Command to run
     * @param bool $verbose If false, only important messages are returned
     * @return array Parsed result lines
     * @throws VagrantRuntimeException
     */
    protected function runCommand(string $command): array {
        $response = [];
        exec('vagrant ' . $command . ' --machine-readable', $response);            

        $parsedLines = VagrantOutputParser::parseLineArray($response);

        if (! $this->getVerbose()) {
            $parsedLines = array_filter($parsedLines, function(VagrantLogEntry $logLine) {
                return in_array($logLine->getType(), [
                    VagrantLogType::ACTION,
                    VagrantLogType::BOX_NAME,
                    VagrantLogType::BOX_PROVIDER,
                    VagrantLogType::ERROR_EXIT,
                    VagrantLogType::STATE_HUMAN_LONG
                ]);
            });
        }
        
        foreach($parsedLines as $logEntry) {
            echo $this->formatLogLine($logEntry) . "\n";
        }
        
        $errors = array_filter($parsedLines, function(VagrantLogEntry $logLine) {
            return $logLine->getType() === VagrantLogType::ERROR_EXIT;
        });
        
        if (count($errors) > 0) {
            throw new BuildException($this->formatLogLine($errors[0]));
        }
        
        return $response;
    }
    
    /**
     * Formats a parsed Vagrant log entry into something nicer for output
     * @param VagrantLogEntry $logEntry Log entry to format
     * @return string Formatted log entry
     */
    protected function formatLogLine(VagrantLogEntry $logEntry): string {
        $formattedTime = '[' . date('Y-M-d H:i:s', $logEntry->getTimestamp()) . ']';
        $formattedType = '[' . strtoupper($logEntry->getType()) . ']';
        return $formattedTime . $formattedType . ' ' . implode(', ', $logEntry->getData());
    }
    
    /**
     * Returns whether to show verbose logging
     * @return bool
     */
    public function getVerbose(): bool {
        return $this->verbose;
    }

    /**
     * Sets whether to show verbose logging
     * @return bool
     */
    public function setVerbose(bool $verbose): void {
        $this->verbose = $verbose;
    }
    
    /**
     * Returns whether logging output is turned off (overrides verbosity)
     * @return bool
     */
    public function getSilent(): bool {
        return $this->silent;
    }

    /**
     * Sets whether to run silently (no output) - overrides verbosity
     * @param bool $silent
     * @return void
     */
    public function setSilent(bool $silent): void {
        $this->silent = $silent;
    }
    
}
