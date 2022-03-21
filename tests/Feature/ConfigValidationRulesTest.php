<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConfigValidationRulesTest extends TestCase
{

    public function testConfigHasKeyRuleSuccess()
    {
        $this->fillFakeConfig();

        $this->assertFalse(validator(['val' => 'a'], ['val' => ['config_has_key:fake']])->fails());

        $this->clearFakeConfig();
    }

    public function testConfigHasKeyRuleFails()
    {
        $this->fillFakeConfig();

        $this->assertTrue(validator(['val' => 'c'], ['val' => ['config_has_key:fake']])->fails());

        $this->clearFakeConfig();
    }

    public function testConfigInArrayRuleSuccess()
    {
        $this->fillFakeConfig();

        $this->assertFalse(validator(['val' => 'valA'], ['val' => ['config_in_array:fake']])->fails());

        $this->clearFakeConfig();
    }

    public function testConfigInArrayRuleFails()
    {
        $this->fillFakeConfig();

        $this->assertTrue(validator(['val' => 'valC'], ['val' => ['config_in_array:fake']])->fails());

        $this->clearFakeConfig();
    }

    private function fillFakeConfig()
    {
        config()->set('fake', [
            'a' => 'valA',
            'b' => 'valB'
        ]);
    }

    private function clearFakeConfig()
    {
        config()->offsetUnset('fake');
    }
}
