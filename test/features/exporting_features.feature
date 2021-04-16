Feature: Exporting features to HTML

  Scenario: convert a simple scenario to HTML

    Given the directory "features" has a file called "example.feature" containing:
    """
    Feature: Feature title

      Scenario: Scenario title
        Given step
        When step
        Then step
    """

    When I export this directory to HTML
    Then the export directory should have a file called "example.html" containing:
    """
    <div class="feature">
      <div class="feature-title">
        <span class="keyword">Feature</span>: <span class="title">Feature title</span>
      </div>
      <div class="scenario">
        <div class="scenario-title">
          <span class="keyword">Scenario</span> <span class="title">Scenario title</span>
        </div>
        <div class="steps">
          <div class="step">
            <span class="keyword">Given</span> <span class="text">step</span>
          </div>
          <div class="step">
            <span class="keyword">When</span> <span class="text">step</span>
          </div>
          <div class="step">
            <span class="keyword">Then</span> <span class="text">step</span>
          </div>
        </div>
      </div>
    </div>
    """
