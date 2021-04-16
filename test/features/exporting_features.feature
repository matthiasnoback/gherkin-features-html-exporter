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

  Scenario: convert a table to HTML

    Given the directory "features" has a file called "table.feature" containing:
    """
    Feature: Feature title

      Scenario: Scenario title
        Given step:
          | Row 1 column 1 | Row 1 column 2 |
          | Row 2 column 1 | Row 2 column 2 |
    """
    When I export this directory to HTML
    Then the export directory should have a file called "table.html" containing:
    """
    <div class="step">
      <span class="keyword">Given</span> <span class="text">step:</span>
      <div class="table-argument">
        <table>
          <tbody>
          <tr>
            <td>Row 1 column 1</td>
            <td>Row 1 column 2</td>
          </tr>
          <tr>
            <td>Row 2 column 1</td>
            <td>Row 2 column 2</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    """

  Scenario: combine multiple features by tag in a single file
    Given the directory "features" has a file called "interesting_1.feature" containing:
    """
    @interesting
    Feature: to be included 1
      Scenario:
        Given step
    """
    And this directory has a file called "interesting_2.feature" containing:
    """
    @interesting
    Feature: to be included 2
      Scenario:
        Given step
    """
    And this directory has a file called "irrelevant.feature" containing:
    """
    @irrelevant
    Feature: irrelevant
      Scenario:
        Given step
    """
    When I export this directory to HTML providing the tag "interesting"
    Then the export directory should have a file called "interesting.html" containing:
    """
    <div class="feature">
      <div class="feature-title">
        <span class="keyword">Feature</span>: <span class="title">to be included 1</span>
      </div>
    """
    And this file should also contain:
    """
    <div class="feature">
      <div class="feature-title">
        <span class="keyword">Feature</span>: <span class="title">to be included 2</span>
      </div>
    """
    And the file "interesting.html" should not contain "irrelevant"
