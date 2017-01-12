// Needed for search suggestions
"use strict";

var YAHOO = { Finance: { SymbolSuggest: {} } };

// When ready...
$(document).ready(function () {

  // Open menu when user clicks
  $("#user").click(function () {
    $("#menu").toggle().menu();
  });

  // If we're on the stock page
  var matches = window.location.href.match(/\/stocks\/(.*)$/);
  if (matches) {
    $('#stock').hide();
    getStock(matches[1]);
  }

  // If we're on the home page
  if (window.location.href == "http://stocks.app/") {
    getAllNews();
    tickerStrip();
  }

  /**
   * Search bar
   */
  $("#searchForm").on('submit', function (e) {
    e.preventDefault();
  });

  // Set focus to the search bar on each page
  $('#search').focus();

  /* Get suggestions on search
     This is now done through the server as Yahoo started rejecting
     jsonp requests. */
  $("#search").autocomplete({
    source: function source(request, response) {
      $.ajax({
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "http://stocks.app/stocks/search/" + request.term,
        success: function success(data) {
          response($.map(data.ResultSet.Result, function (item) {
            if (item.symbol.length < 10) // Remove invalid data
              {
                return {
                  label: item.name + " [" + item.symbol + "]",
                  value: item.symbol
                };
              }
          }));

          // CSS Fix so table will hide overflow
          if ($(".ui-autocomplete-container").length === 0) {
            $(".ui-autocomplete").wrap("<div class='ui-autocomplete-container'></div>");
            $(".ui-autocomplete").wrap("<div class='container'></div>");
          }
          $(".ui-autocomplete-container").insertAfter(".navbar");
          $(".navbar-top").css("border", "1px solid #DDD").css("box-shadow", "none");

          // Change stock to first result
          changeStock(data.ResultSet.Result[0].symbol);

          // Change stock to item pressed
          $(".ui-menu-item").click(function () {
            changeStock($(this).text().match(/\[(.*?)]/));
          });
        }
      });
    }
  });

  /**
   * Show loading icon
   */
  function loading() {

    // Show loading
    $("#loading").css("display", "inline-block");
    $("#content").hide();
  }

  /**
   * Hide loading icon
   */
  function stopLoading() {
    // Hide loading
    $('#loading').hide();

    // Show content
    $('#content').show();
    $('#stock').show();
  }

  /**
   * Get stock when on stock page
   *
   * @param symbol
   */
  function getStock(symbol) {
    // Show loading
    loading();

    // Get the stock
    requestStock(symbol, function (data) {
      if (data.query && data.query.results) {
        insertStockInfo(data.query.results.quote);
        stopLoading();
      } else {
        // Throw 404 if not found
        window.location.href = '/404';
      }
    });
  }

  /**
   * Change stock when searching
   *
   * @param symbol
   */
  function changeStock(symbol) {
    // Show loading
    loading();

    requestStock(symbol, function (data) {
      var quote = data.query.results.quote;

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "http://stocks.app/stocks/" + quote.Symbol,
        data: {
          ajax: 1
        },
        success: function success(data) {
          $('#content').html(data);
          insertStockInfo(quote);
          stopLoading();
        }
      });
    });
  }

  /**
   * Get stock data
   *
   * @param symbol
   * @param success
   */
  function requestStock(symbol, _success) {

    // Request data
    $.ajax({
      url: "http://query.yahooapis.com/v1/public/yql",
      data: {
        q: "select * from yahoo.finance.quotes where symbol = '" + symbol + "'",
        format: "json",
        env: "store://datatables.org/alltableswithkeys"
      },
      success: function success(data) {
        _success(data);

        // Change URL
        history.pushState(window.event.state, data.query.results.quote.Name, "http://stocks.app/stocks/" + symbol);
      }
    });
  }

  /**
   * Get news for homepage
   */
  function getAllNews() {
    // Send request to yahoo's servers
    $.ajax({
      url: "https://query.yahooapis.com/v1/public/yql",
      data: {
        q: "select * from rss(0,6) where url='https://uk.finance.yahoo." + "com/news/topic-top-stories/?format=rss'",
        format: "json"
      },
      dataType: "jsonp",
      jsonp: "callback",
      cache: true,
      success: function success(data) {
        // Insert news into the news table.
        insertNews(data);
      },
      error: function error() {
        $("#news").append("Failed to retrieve headlines.");
      },
      timeout: 2000
    });
  }

  /**
   * Get news for stock
   *
   * @param symbol
   */
  function getNews(symbol) {
    // Send request
    $.ajax({
      type: "GET",
      url: "https://query.yahooapis.com/v1/public/yql",
      data: {
        q: "select * from rss(0,6) where url='http://feeds.finance.ya" + "hoo.com/rss/2.0/headline?region=US&lang=en-US&s=" + symbol + "'",
        format: "json"
      },
      dataType: "jsonp",
      jsonp: "callback",
      cache: true,
      success: function success(data) {
        // Insert news into the news table.
        insertNews(data);
      },
      error: function error() {
        $("#news").append("Failed to retrieve headlines.");
      },
      timeout: 2000
    });
  }

  /**
   * Generate ticker strip on home page
   */
  function tickerStrip() {
    // Request data
    $.ajax({
      url: "http://query.yahooapis.com/v1/public/yql",
      data: {
        q: "select * " + "from yahoo.finance.quotes " + "where symbol in ('^FTSE', '^FTMC', '^N225', '^NDX', '^GSPC', '^FCHI')",
        format: "json",
        env: "store://datatables.org/alltableswithkeys"
      },
      success: function success(data) {
        // Insert into marquee
        data.query.results.quote.forEach(function (quote) {
          if (quote.Change == null) {
            return;
          }

          // Setup colours
          var green = $("<span style='color:green'></span>");
          var bGreen = $("<span style='color:green;font-weight: bold'></span>");
          var red = $("<span style='color:red'></span>");
          var bRed = $("<span style='color:red;font-weight: bold'></span>");

          var marquee = $(".marquee");

          // Add link
          var url = "stocks/" + quote.Symbol;
          marquee.append('<a href="' + url + '">' + quote.Name + '</a> ');

          // Add change
          if (quote.Change.indexOf("+") !== -1) {
            marquee.append(green.html("<i class='fa fa-caret-up'></i> "));
            marquee.append(quote.Ask || quote.LastTradePriceOnly);
            // Remove + or - from percentage
            var changeP = quote.ChangeinPercent.substring(1);
            marquee.append(bGreen.html(" (" + changeP + ")"));
          } else {
            marquee.append(red.html("<i class='fa fa-caret-down'></i> "));
            marquee.append(quote.Ask || quote.LastTradePriceOnly);
            // Remove + or - from percentage
            var changeP = quote.ChangeinPercent.substring(1);
            marquee.append(bRed.html(" (" + changeP + ")"));
          }
          $(".marquee").append("&nbsp&nbsp&nbsp&nbsp&nbsp</span>");
        });
        $(".marquee").marquee({
          gap: 10,
          duration: 10000,
          duplicated: true,
          pauseOnHover: true
        });
      },
      error: function error() {
        $(".marquee").hide();
      },
      timeout: 5000
    });
  }

  /**
   * Add stock into
   *
   * @param quote
   */
  function insertStockInfo(quote) {
    document.title = quote.symbol;
    $(".symbol").prepend(quote.symbol);
    $(".name").prepend(quote.Name);
    var price = quote.Ask || quote.LastTradePriceOnly;
    $(".price").prepend(price);
    $(".change").prepend(quote.Change);
    // Remove + or - from percentage
    var changeP = quote.ChangeinPercent.substring(1);
    $(".changeP").prepend("(" + changeP + ")");

    // Change buy amount
    $("#priceBuy").text(price);
    $("#amountBuy").change(function () {
      var newPrice = price * $("#amountBuy").val();
      $("#priceBuy").text(newPrice.toPrecision(5));
    });

    if ($(".change").text().indexOf("+") !== -1) {
      $(".change").attr('style', 'color: green');
      $(".changeP").attr('style', 'color: green');
    } else {
      $(".change").attr('style', 'color: red');
      $(".changeP").attr('style', 'color: red');
    }

    $("#symbolImage").attr("src", "http://chart.finance.yahoo.com/z?&t=6m&q=l&l=on&z=l&p=m50,e200,v&s=" + quote.symbol);
    if ($(".breadcrumb li").length > 1) {
      $(".breadcrumb li:last").remove();
    }
    $(".compare").each(function () {
      // Get text
      var text = $(this).text();

      // Calculate percentage
      var percentage = (price - text) / price * 100;

      // Get amount
      var amount = $(this).closest("tr").find(".form-control").first().attr("value");

      // Calculate profit
      var profit = amount * (text - price);

      // Setup colours
      var green = $("<span style='color:green'></span>");
      var red = $("<span style='color:red'></span>");

      // Setup strings
      var percentageString = "(" + percentage.toFixed(2).toString() + "%)";
      var profitString = "<br>+$" + profit.toFixed(2).toString();

      // Insert data
      if (percentage >= 0) {
        $(this).html(green.html("<i class='fa fa-caret-up'></i>"));
        $(this).append(text);
        $(this).append(green.html(percentageString));
        $(this).append(green.html(profitString));
      } else {
        $(this).html(red.html("<i class='fa fa-caret-down'></i>"));
        $(this).append(text);
        $(this).append(red.html(percentageString));
        $(this).append(red.html(profitString));
      }
    });
    // Add symbol to the breadcrumb
    $(".breadcrumb").append("<li>" + quote.symbol + "</li>");

    // Insert news
    getNews(quote.symbol);
  }

  /**
   * Insert the news into the news table.
   *
   * @param data
   */
  function insertNews(data) {
    if (data.query && data.query.results.item[0]) {
      // Loop through news items
      data.query.results.item.forEach(function (entry, i) {
        // Get link and date of first items.
        var link = $("#news a:eq(" + i + ")");
        var date = $("#news .date:eq(" + i + ")");

        // Insert link and date
        link.attr('href', entry.link);
        link.html(entry.title);
        date.html(entry.pubDate);

        // Add description
        if (entry.description) {
          // Remove html
          link.attr('title', strip(entry.description));
        } else {
          link.attr('title', "No description.");
        }
      });
    } else {
      // No news
      $("#news").append("No news has been found.");
    }
  }

  function strip(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
  }
});
//# sourceMappingURL=search.js.map
