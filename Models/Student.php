<?php


class Student
{
    private string $name;
    private string $surname;
    private string $studentID;
    private string $testID;
    private bool $tab_focus;

    /**
     * Student constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getStudentID(): string
    {
        return $this->studentID;
    }

    /**
     * @param string $studentID
     */
    public function setStudentID(string $studentID): void
    {
        $this->studentID = $studentID;
    }

    /**
     * @return string
     */
    public function getTestID(): string
    {
        return $this->testID;
    }

    /**
     * @param string $testID
     */
    public function setTestID(string $testID): void
    {
        $this->testID = $testID;
    }

    /**
     * @return bool
     */
    public function isTabFocus(): bool
    {
        return $this->tab_focus;
    }

    /**
     * @param bool $tab_focus
     */
    public function setTabFocus(bool $tab_focus): void
    {
        $this->tab_focus = $tab_focus;
    }


}