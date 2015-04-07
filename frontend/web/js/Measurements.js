var bloodhoundRunning = false;
var measurementTypes = {"boolean": "True/False",
  "float": "Number", "letter": "Letter Size", "custom": "Custom"};
var loadDialogEvent = "load-dialog-event";
var dialogMeasurementDataParam = "measurementParent";
var newMeasurementErrorHtml = "<div class='addErrors error-summary'>" +
  "The new measurement couldn't be added. Is its name valid? If so, please " +
    "contact your system administrator for assistance.</div>";
var sameNameMeasurementErrorHtml = "<div class='editErrors error-summary'>" +
  "There was an error processing the measurement change. Is the " +
  "measurement name the same as another measurement&apos;s name?</div>";
var measurementPostErrorHtml = "<div class='measurementErrorMessage error-summary'>" +
  "<i>There was an error processing the delete. Please contact your system " +
    "administrator for assistance.</i></div>";

$(document).ready(function() {
  resetMeasurementsContainerHtml();

  //////////////////////////////////
  // set up search typeahead for measurement names
  var measurements = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      maxParallelRequests: 0,
      url: '?r=sport-measurement%2Fget-measurements-by-name&measurementName=%QUERY',
      ajax: {
        type: "GET",
        timeout: 10000,
        beforeSend: function(jqXHR, settings) {
          // only allow one request at a time
          if (bloodhoundRunning) {
            return false;
          }

          bloodhoundRunning = true;
          //$('#loader1').show();
        },
        complete: function(jqXHR, textStatus) {
          bloodhoundRunning = false;
          //$('#loader1').hide();
        }
      },
      filter: function (users) {
        return $.map(users, function(measurementNamesArray) {
          return {value: measurementNamesArray.name}
        })
      }
    }
  });

  measurements.initialize();

  $('.existingMeasurementValues .typeahead').typeahead(null, {
    highlight: true,
    minLength: 3,
    displayKey: 'value',
    source: measurements.ttAdapter(),
    templates: {
      empty: ['<div class="empty-message">',
        'No measurements found',
        '</div>'
      ].join('\n'),
      suggestion: function (value) {
        return '<p class="repo-language"><b>' + value.value + '</b></p>'
      }
    }
  });
  ////////////////////////////////////

  // remove any measurements visible when sport category select is changed
  $('#sportCategory').change(function() {
    resetMeasurementsContainerHtml();
    swapNewMeasurementVisibility(false);
  });

  // add functionality for the 'get measurements' button
  $('.getMeasurements').click(function() {
    var sportId = $('#sportCategory').val();
    $.get("?r=sport-measurement%2Fget-sport-measurements&sportId="
          + sportId, function(data) {
      $('.measurementsContainer').css('color', '');
      $('.measurementsContainer').html(data);

      // make new requirement container visible
      swapNewMeasurementVisibility(true);
    })
  });

  // set up display-edit swap when a measurement title is clicked
  $('body').on('click', '.measurementName', function() {
    $(this).parent().hide();
    $(this).parent().next('.editMeasurement').show();
  });

  // add functionality to the 'save' buttons in the edit measurement sections
  $('body').on('click', '.editMeasurementBtns .saveMeasurement', function() {
    addSaveBtnFunctionality($(this));
  });

  $('body').on('click', '.deleteMeasurement', function() {
    var parentElement = $(this).closest('.measurement').first();
    var originalMeasurementNode = $(parentElement).find(".originalMeasurementId").first();

    // store dialog measurement node for reference on 'delete' button click from dialog box
    $('.dialogBox').data(dialogMeasurementDataParam, $(originalMeasurementNode));

    var measurementName = $(parentElement).find('.originalMeasurementName').html();
    showDeleteDialog(measurementName);
  });

  // set up 'cancel edit' buttons
  $('body').on('click', '.cancelEdit', function() {
    //$('.measurementErrorMessage').remove();
    resetEdit($(this).closest('.measurement').first());
  });

  // add functionality for the 'add (new) measurement' button
  $('.addNewMeasurementBtn').click(function() {
    addNewMeasurementBtnFunctionality();
  });

  // add functionality for the 'add (existing) measurement' button
  $('.addExistingMeasurementBtn').click(function() {
    addExistingMeasurementBtnFunctionality();
  });

  $('.deleteMeasurementBtn').click(function() {
    $('.measurementErrorMessage').remove();

    // retrieve parent 'measurement node' of original measurement ID
    // node stored above
    var parentMeasurementNode = $($('.dialogBox').data(dialogMeasurementDataParam))
        .closest('.measurement').first();
    var measurementId = $.trim($(parentMeasurementNode)
        .find('.originalMeasurementId').html());

    // MAKE REST CALL HERE
    var sportId = $('#sportCategory').val();
    $.post("?r=sport-measurement%2Fdelete-measurement-from-sport",
      {"measurementId": measurementId, "sportId": sportId},
      function(result) {
        $(parentMeasurementNode).remove();
      }).error(function() {
        $(parentMeasurementNode).find('.editMeasurementBtns').first()
            .after(measurementPostErrorHtml);
      }).always(function() {
        resetDeleteDialog();
    });
  });

  $('.cancelDeleteBtn').click(function() {
    resetDeleteDialog();
  });
});

function showDeleteDialog(measurementName) {
  // place name of measurement in delete dialog box
  setDeleteDialogMeasurementDisplayName(measurementName);

  // show the dialog box
  $('.dialogBox').show();
}

function resetDeleteDialog() {
  $('.dialogBox').data(dialogMeasurementDataParam, '');
  setDeleteDialogMeasurementDisplayName('');
  $('.dialogBox').hide();
}

function setDeleteDialogMeasurementDisplayName(name) {
  $('.deleteMeasurementName').html(name);
}

function resetMeasurementsContainerHtml() {
  $('.measurementsContainer').css('color', '#ccc');
  $('.measurementsContainer').html("<i>Click the " +
    "'Get Measurements' button above to load the required " +
    "measurements for a sport</i>");
}

function swapNewMeasurementVisibility(setVisible) {
  if (setVisible) {
    $('.horizontalRule').show();
    $('.addMeasurementContainer').show();
  }
  else {
    $('.horizontalRule').hide();
    $('.addMeasurementContainer').hide();
  }
}

function addSaveBtnFunctionality(saveBtnElement) {
  var parentElement = $(saveBtnElement).closest('.measurement').first();
  $(parentElement).find('.editErrors').first().hide();

  // gather strings and nodes for calculation
  var originalNameElement = $(parentElement).children('.originalMeasurementName');
  var originalTypeElement = $(parentElement).find('.originalMeasurementType').first();
  var inputElement = $(parentElement).find('.measurementNameInput').first();
  var selectElement = $(parentElement).find('.measurementTypeSelect').first();
  var measurementId = $(parentElement).children('.originalMeasurementId').first().html();
  var newMeasurementName = $.trim($(inputElement).val());
  var newMeasurementType = $(parentElement).find('.measurementTypeSelect').first().val();

  // post measurement data to endpoint
  $.post("?r=sport-measurement%2Fadd-or-change-measurement",
    {measurementId: measurementId, measurementName: newMeasurementName,
      "measurementType": newMeasurementType},
    function() {
      // reset the measurement's hidden variable values
      $(originalNameElement).html(newMeasurementName);
      $(originalTypeElement).html(newMeasurementType);

      // reset measurement display name, type, and edit state
      rewriteDisplayNameAndType(parentElement, newMeasurementName, newMeasurementType);
      resetEdit($(parentElement));
    }
  ).error(function() {
      // replace the name input element's value with the original measurement name
      $(inputElement).val($.trim($(originalNameElement).html()));
      // replace the select element's value with the original measurement type
      $(selectElement).val($.trim($(originalTypeElement).html()));
      // show the 'errors' div
      $(parentElement).find('.measurementTypeSelectContainer')
          .first().after(sameNameMeasurementErrorHtml);
    }
  );
}

function rewriteDisplayNameAndType(parentElement, newName, newType) {
  $(parentElement).find('.measurementName').first().html(newName);
  $(parentElement).find('.measurementType').first().html(measurementTypes[newType]);
}

function resetEdit(parentElement) {
  // reset errors
  $('.measurementErrorMessage').remove();

  $(parentElement).find('.displayMeasurement').first().show();
  $(parentElement).find('.editMeasurement').first().hide();
}

function addNewMeasurementBtnFunctionality() {
  setNewMeasurementError(false, "");

  var newMeasurementName = $.trim($('.newMeasurementNameInput').val()).toLowerCase();
  var newMeasurementType = $('.newMeasurementTypeSelect').val();
  var sportId = $('#sportCategory').val();

  $.post("?r=sport-measurement%2Fadd-or-change-measurement",
         {"measurementName": newMeasurementName,
          "measurementType": newMeasurementType,
          "sportId": sportId,
          "getElementHtml": true},
         function(newMeasurementHtml) {
           $(newMeasurementHtml).insertBefore('.editInstructions');
           $('.newMeasurementNameInput').val('');
    }).error(
    function() {
      setNewMeasurementError(true);
    });
}

function addExistingMeasurementBtnFunctionality() {
  setExistingMeasurementError(false, "");

  var measurementName = $.trim($('#existingMeasurementNameInputId').val());
  var sportId = $('#sportCategory').val();

  $.post("?r=sport-measurement%2Fadd-existing-measurement-to-collection",
      {"sportId": sportId, "measurementName": measurementName},
    function(existingMeasurementHtml) {
      $('.editInstructions').before(existingMeasurementHtml);
    }).error(function() {
        //
      });
}

function setNewMeasurementError(isError) {
  if (isError) {
    $('.newMeasurementValues').after(newMeasurementErrorHtml);
  }
  else {
    $('.addErrors').remove();
  }
}

function setExistingMeasurementError(isError) {
  if (isError) {
    $('.existingMeasurementValues').after(newMeasurementErrorHtml);
  }
  else {
    $('.addErrors').remove();
  }
}
