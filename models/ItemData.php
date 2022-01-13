<?php
class ItemData {

    protected $_appid, $_releaseDate, $_english, $_developer, $_publisher, $_status,
    $_platforms, $_requiredAge, $_categories, $_genres, $_tags, $_achievements,
    $_positiveRatings, $_negativeRatings, $_averagePlaytime, $_medianPlaytime, $_physical,
    $_unitsAvailable, $_unitsSold, $_price;

    public function __construct($dbRow) {
        $this->_appid = $dbRow['appid'];
        $this->_releaseDate = $dbRow['release_date'];
        $this->_english = $dbRow['english'];
        $this->_developer = $dbRow['developer'];
        $this->_publisher = $dbRow['publisher'];
        $this->_status = $dbRow['status'];
        $this->_platforms = $dbRow['platforms'];
        $this->_requiredAge = $dbRow['required_age'];
        $this->_categories = $dbRow['categories'];
        $this->_genres = $dbRow['genres'];
        $this->_tags = $dbRow['tags'];
        $this->_achievements = $dbRow['achievements'];
        $this->_positiveRatings = $dbRow['positive_ratings'];
        $this->_negativeRatings = $dbRow['negative_ratings'];
        $this->_averagePlaytime = $dbRow['average_playtime'];
        $this->_medianPlaytime = $dbRow['median_playtime'];
        $this->_physical = $dbRow['physical'];
        $this->_unitsAvailable = $dbRow['units_available'];
        $this->_unitsSold = $dbRow['units_sold'];
        $this->_price = $dbRow['price'];
    }

    public function getAppId() {
        return $this->_appid;
    }

    public function getReleaseDate() {
        return $this->_releaseDate;
    }

    public function getEnglish() {
        return $this->_english;
    }

    public function getDeveloper() {
        return $this->_developer;
    }

    public function getPublisher() {
        return $this->_publisher;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function getPlatforms() {
        return $this->_platforms;
    }

    public function getRequiredAge() {
        return $this->_requiredAge;
    }

    public function getCategories() {
        return $this->_categories;
    }

    public function getGenres() {
        return $this->_genres;
    }

    public function getTags() {
        return $this->_tags;
    }

    public function getAchievements() {
        return $this->_achievements;
    }

    public function getPositiveRatings() {
        return $this->_positiveRatings;
    }

    public function getNegativeRatings() {
        return $this->_negativeRatings;
    }

    public function getAveragePlaytime() {
        return $this->_averagePlaytime;
    }

    public function getMedianPlaytime() {
        return $this->_medianPlaytime;
    }

    public function getPhysical() {
        return $this->_physical;
    }

    public function getUnitsAvailable() {
        return $this->_unitsAvailable;
    }

    public function getUnitsSold() {
        return $this->_unitsSold;
    }

    public function getPrice() {
        return $this->_price;
    }
}


