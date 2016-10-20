<?php
/**
 * Plugin Name: OffTheShelf Last Tweets
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays the last tweet.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Last_Tweets_Widget' ) ) {
	class OffTheShelf_Last_Tweets_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Last Tweets', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays the last tweets.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-last-tweets' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'  => esc_html__( 'Info', 'offtheshelf' ),
					'desc'  => esc_html__( 'You can define your Twitter account details in the profile under section "Social Media".', 'offtheshelf' ),
					'id'    => 'info',
					'value' => '',
					'type'  => 'paragraph'
				),
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Last Tweets', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Amount of tweets to retrieve', 'offtheshelf' ),
					'desc'     => esc_html__( 'Retweets, even if not displayed, count.', 'offtheshelf' ),
					'id'       => 'amount',
					'type'     => 'number',
					'std'      => '3',
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Include retweets', 'offtheshelf' ),
					'id'       => 'include_retweets',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
			); // fields array


			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$tweets = $this->show( $instance );

			if ( $tweets ) {
				$out = $args['before_widget'];

				$title = offtheshelf_array_option( "title", $instance );
				if ( $title != "" ) {
					$out .= $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}

				$out .= $tweets;

				$out .= $args['after_widget'];

				echo $out;
			}
		}

		public function format_tweet( $text ) {
			$text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text );
			$text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text );
			$text = preg_replace( "/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text );
			$text = preg_replace( "/#(\w+)/", "<a href=\"http://twitter.com/search?q=%23\\1%26src=hash\" target=\"_blank\">#\\1</a>", $text );

			return $text;
		}

		public function show( $instance ) {
			$tweets = $this->get( $instance );
			$out    = '';

			if ( $tweets ) {

				$out .= '<ul class="tweets">';
				foreach ( $tweets as $tweet ) {
					$out .= '<li>';
					/** Get the date and time posted as a nice string */
					$posted_since = apply_filters( 'offtheshelf_tweets_posted_since', human_time_diff( strtotime( $tweet->created_at ), current_time( 'timestamp' ) ) . ' ago' );

					/** Filter for linking dates to the tweet itself */
					$link_date = apply_filters( 'offtheshelf_tweets_link_date_to_tweet', __return_false() );
					if ( $link_date ) {
						$posted_since = '<a href="' . esc_url ( 'https://twitter.com/' . $tweet->user->screen_name . '/status/. ' . $tweet->id_str ) . '">' . $posted_since . '</a>';
					}

					if ( is_ssl() ) {
						$avatar_url = str_replace( "_normal", "_bigger", $tweet->user->profile_image_url_https );
					} else {
						$avatar_url = str_replace( "_normal", "_bigger", $tweet->user->profile_image_url );
					}

					$out .= '<a href="' . esc_url ( 'http://www.twitter.com/' . $tweet->user->screen_name ) . '" target="_blank"><img class="last-tweet-avatar" src="' . esc_url ( $avatar_url ) . '" alt="' . esc_attr( $tweet->user->screen_name ) . '"></a>';
					$out .= '<p>' . offtheshelf_esc_html ( $this->format_tweet( $tweet->text ) ) . '</p>';
					$out .= '<span class="last-tweet-time">' . $posted_since . '</span>';

					$out .= '</li>';
				}
				$out .= '</ul>';
			}
			if ( isset( $out ) ) {
				return $out;
			} else {
				return false;
			}
		}

		public function get( $instance ) {
			$twitter_user            = offtheshelf_option( 'twitter_user' );
			$twitter_consumer_key    = offtheshelf_option( 'twitter_consumer_key' );
			$twitter_consumer_secret = offtheshelf_option( 'twitter_consumer_secret' );
			$twitter_token_key       = offtheshelf_option( 'twitter_access_token' );
			$twitter_token_secret    = offtheshelf_option( 'twitter_access_token_secret' );

			$args = array(
				'screen_name'     => $twitter_user,
				'count'           => offtheshelf_array_option( "amount", $instance, 1 ),
				'include_rts'     => offtheshelf_array_option( "include_retweets", $instance, '1' ),
				'exclude_replies' => '1'
			);

			$tag = offtheshelf_array_option( "amount", $instance, 1 ) . "_" . offtheshelf_array_option( "include_retweets", $instance, '1' );

			/** Get tweets from transient. False if it has expired */
			$tweets = get_transient( "offtheshelf_last_tweets_" . $twitter_user . $tag );
			if ( defined( 'OFFTHESHELF_TWITTER_CACHE' ) && OFFTHESHELF_TWITTER_CACHE == true ) {
				$tweets = false;
			}

			if ( $tweets === false ) {
				/** Get Twitter connection */
				$settings = array(
					'oauth_access_token'        => $twitter_token_key,
					'oauth_access_token_secret' => $twitter_token_secret,
					'consumer_key'              => $twitter_consumer_key,
					'consumer_secret'           => $twitter_consumer_secret
				);


				$url      = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

				$getfield = '?' . http_build_query( $args, '', '&' );

				$request_method = 'GET';

				$twitter_instance = new Twitter_API_WordPress( $settings );

				$result = $twitter_instance
					->set_get_field( $getfield )
					->build_oauth( $url, $request_method )
					->process_request();

				$tweets = json_decode( $result );

				/** Bail if failed */
				if ( ! $tweets || isset( $tweets->errors ) || isset( $tweets->error ) ) {
					return false;
				}

				/** Set tweets */
				set_transient( "offtheshelf_last_tweets_" . $twitter_user . $tag, $tweets, 300 );
			}


			return $tweets;

		}


	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_last_tweets_widget' ) ) {
		function register_offtheshelf_last_tweets_widget() {
			register_widget( 'OffTheShelf_Last_Tweets_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_last_tweets_widget', 1 );
	}
}